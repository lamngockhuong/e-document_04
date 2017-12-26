<?php

use Illuminate\Database\Seeder;

class TermTaxonomyDocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documents = \App\Models\Document::all();

        App\Models\TermTaxonomy::all()->each(function ($termtaxonomy) use ($documents) {
            $termtaxonomy->documents()->attach(
                $documents->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
