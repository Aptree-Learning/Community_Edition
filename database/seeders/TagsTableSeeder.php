<?php

namespace Database\Seeders;

use Str;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->data() as $item){
            Tag::firstOrCreate(['name' => $item, 'slug' => Str::slug($item)]);
        }
    }

    public function data() // ChatGPT
    {
        $tags = array(
            "Management",
            "Leadership",
            "Strategic management",
            "Team management",
            "Project management",
            "Sales",
            "Marketing",
            "Advertising",
            "Market research",
            "Sales management",
            "Operations",
            "Logistics",
            "Manufacturing",
            "Supply chain management",
            "Facilities management",
            "Finance",
            "Accounting",
            "Financial analysis",
            "Tax accounting",
            "Auditing",
            "Human resources",
            "Talent management",
            "Recruiting",
            "Employee relations",
            "Compensation",
            "Benefits",
            "Information technology",
            "Computer science",
            "Software development",
            "Cybersecurity",
            "Database management",
            "Engineering",
            "Technical services",
            "Mechanical engineering",
            "Electrical engineering",
            "Civil engineering",
            "Customer service",
            "Technical support",
            "Customer success",
            "Call center management",
            "Research",
            "Development",
            "Product development",
            "Scientific research",
            "Innovation management",
            "Creative",
            "Design",
            "Graphic design",
            "User experience design",
            "Art direction",
            "Health",
            "Medical services",
            "Nursing",
            "Physical therapy",
            "Healthcare administration",
            "Education",
            "Training",
            "Curriculum development",
            "Teaching",
            "Instruction",
            "eLearning design",
            "Government",
            "Public administration",
            "Public policy",
            "Legislative affairs"
        );

        return $tags;

    }
}
