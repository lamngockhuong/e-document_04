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
            $term->termtaxonomy()->saveMany(factory(TermTaxonomy::class, 1)->make(['parent' => 0]));
        });

        factory(Term::class, 5)->create()->each(function (Term $term) {
            $term->termtaxonomy()->saveMany(factory(TermTaxonomy::class, 1)->make(['parent' => $this->getRandomTermId()]));
        });
    }

    private function getRandomTermId()
    {
        $randomTerm = Term::inRandomOrder()->first();
        return !is_null($randomTerm) ? $randomTerm->id : null;
    }
}
