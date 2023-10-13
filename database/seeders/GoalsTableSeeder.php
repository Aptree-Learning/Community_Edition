<?php

namespace Database\Seeders;

use App\Models\Goal;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titles = array(
            "Full-Stack Web Developer",
            "Certified AWS DevOps Engineer",
            "Cybersecurity Specialist",
            "Data Scientist",
            "Digital Marketing Strategist",
            "Certified Financial Planner",
            "Certified Nursing Assistant",
            "User Experience Designer",
            "iOS Mobile App Developer",
            "Project Management Professional",
            "Artificial Intelligence Engineer",
            "Business Analyst",
            "Cloud Solutions Architect",
            "Game Developer",
            "Graphic Designer",
            "Information Security Analyst",
            "Network Administrator",
            "Product Manager",
            "Salesforce Developer",
            "Social Media Manager"
        );

        foreach($titles as $title){
            Goal::firstOrCreate(['name' => $title]);
        }
    }
}
