<?php

use App\Models\Term;
use App\Models\TermTaxonomy;
use Illuminate\Database\Seeder;

class TermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Term::class, 5)->create()->each(function (Term $term) {
            $taxonomy = ['tag', 'category'];
            $rand = rand(0, 1);
            $term->termtaxonomy()->saveMany(factory(TermTaxonomy::class, 1)->make([
                'taxonomy' => $taxonomy[$rand],
                'parent' => 0,
            ]));
        });

        factory(Term::class, 5)->create()->each(function (Term $term) {
            $taxonomy = [['tag', 0], ['category', $this->getRandomTermId()]];
            $rand = rand(0, 1);
            $term->termtaxonomy()->saveMany(factory(TermTaxonomy::class, 1)->make([
                'taxonomy' => $taxonomy[$rand][0],
                'parent' => $taxonomy[$rand][1],
            ]));
        });
    }

    private function getRandomTermId()
    {
        $randomTerm = Term::inRandomOrder()->first();
        return !is_null($randomTerm) ? $randomTerm->id : null;
    }
}
