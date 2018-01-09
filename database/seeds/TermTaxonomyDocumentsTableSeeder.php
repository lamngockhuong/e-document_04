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
        $termTaxonomy = \App\Models\TermTaxonomy::all();

        App\Models\Document::all()->each(function ($document) use ($termTaxonomy) {
            $document->termTaxonomys()->attach(
                $termTaxonomy->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
