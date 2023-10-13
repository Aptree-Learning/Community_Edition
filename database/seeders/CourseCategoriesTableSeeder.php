<?php

namespace Database\Seeders;

use Str;
use App\Models\CourseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CourseCategory::factory()->count(100)->create();
        foreach($this->data() as $item)
        {
            $category = CourseCategory::firstOrCreate([
                    'name' => $item['name'], 
                    'slug' => Str::slug($item['name'])
            ]);
            
            foreach($item['subcategories'] as $subcategory)
            {
                $category->subcategories()->firstOrCreate([
                    'name' => $subcategory, 
                    'slug' => Str::slug($subcategory)
                ]);
            }
            
        }
        
    }

    public function data()
    {
        $categories = array(
            array(
              "name" => "Management and leadership",
              "subcategories" => array(
                "Strategic management",
                "Team management",
                "Project management"
              )
            ),
            array(
              "name" => "Sales and marketing",
              "subcategories" => array(
                "Advertising",
                "Market research",
                "Sales management"
              )
            ),
            array(
              "name" => "Operations and logistics",
              "subcategories" => array(
                "Manufacturing",
                "Supply chain management",
                "Facilities management"
              )
            ),
            array(
              "name" => "Finance and accounting",
              "subcategories" => array(
                "Financial analysis",
                "Tax accounting",
                "Auditing"
              )
            ),
            array(
              "name" => "Human resources and talent management",
              "subcategories" => array(
                "Recruiting",
                "Employee relations",
                "Compensation and benefits"
              )
            ),
            array(
              "name" => "Information technology and computer science",
              "subcategories" => array(
                "Software development",
                "Cybersecurity",
                "Database management"
              )
            ),
            array(
              "name" => "Engineering and technical services",
              "subcategories" => array(
                "Mechanical engineering",
                "Electrical engineering",
                "Civil engineering"
              )
            ),
            array(
              "name" => "Customer service and support",
              "subcategories" => array(
                "Technical support",
                "Customer success",
                "Call center management"
              )
            ),
            array(
              "name" => "Research and development",
              "subcategories" => array(
                "Product development",
                "Scientific research",
                "Innovation management"
              )
            ),
            array(
              "name" => "Creative and design",
              "subcategories" => array(
                "Graphic design",
                "User experience design",
                "Art direction"
              )
            ),
            array(
              "name" => "Health and medical services",
              "subcategories" => array(
                "Nursing",
                "Physical therapy",
                "Healthcare administration"
              )
            ),
            array(
              "name" => "Education and training",
              "subcategories" => array(
                "Curriculum development",
                "Teaching and instruction",
                "eLearning design"
              )
            ),
            array(
              "name" => "Government and public administration",
              "subcategories" => array(
                "Public policy",
                "Legislative affairs",
                "Public administration"
              )
            )
          );

        return $categories;
          
    }
}
