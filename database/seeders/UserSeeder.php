<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserEducation;
use App\Models\UserExperience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = ["Google", 'Facebook', 'Apple', 'Microsoft'];
        $educations = ["Complied Bachelor from Oxford University", 'Complied Master from UA University', 'Complied Phd from Nevada University', 'Complied Master from Stanford University'];
        // force truncate 
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('users')->truncate();
        \DB::table('user_education')->truncate();
        \DB::table('user_experiences')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'id' => 1000,
            'first_name' => 'Jhon',
            'last_name' => 'Doe',
            'email' => 'student@gmail.com',
            'password' => bcrypt('1234'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        User::create([
            'id' => 1001,
            'first_name' => 'Jason',
            'last_name' => 'Thorne',
            'email' => 'instructor@gmail.com',
            'password' => bcrypt('1234'),
            'role' => 'instructor',
            'email_verified_at' => now(),
            'short_bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices',
            'bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.

            developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.

            a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.
            ',
            'job_title' => 'Developer',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://twitter.com/',
            'linkedin' => 'https://www.linkedin.com/',
            'website' => 'https://www.websolutionus.com/',
            'github' => 'https://www.github.com/',
        ]);

        for ($i = 0; $i < 4; $i++) {
            UserExperience::create([
                'user_id' => 1001,
                'company' => $companies[$i],
                'position' => 'Developer',
                'start_date' => now()->subYear(),
                'end_date' => now(),
            ]);
            UserEducation::create([
                'user_id' => 1001,
                'organization' => $educations[$i],
            ]);
        }

        User::create([
            'id' => 1002,
            'first_name' => 'Mark',
            'last_name' => 'Davenport',
            'email' => 'instructortwo@gmail.com',
            'password' => bcrypt('1234'),
            'role' => 'instructor',
            'email_verified_at' => now(),
            'short_bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices',
            'bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.

            developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.

            a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.
            ',
            'job_title' => 'Developer',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://twitter.com/',
            'linkedin' => 'https://www.linkedin.com/',
            'website' => 'https://www.websolutionus.com/',
            'github' => 'https://www.github.com/',
        ]);

        for ($i = 0; $i < 4; $i++) {
            UserExperience::create([
                'user_id' => 1002,
                'company' => $companies[$i],
                'position' => 'Developer',
                'start_date' => now()->subYear(),
                'end_date' => now(),
            ]);
            UserEducation::create([
                'user_id' => 1002,
                'organization' => $educations[$i],
            ]);
        }

        User::create([
            'id' => 1003,
            'first_name' => 'Ethan',
            'last_name' => 'Granger',
            'email' => 'instructortrhee@gmail.com',
            'password' => bcrypt('1234'),
            'role' => 'instructor',
            'email_verified_at' => now(),
            'short_bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices',
            'bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.

            developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.

            a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.
            ',
            'job_title' => 'Developer',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://twitter.com/',
            'linkedin' => 'https://www.linkedin.com/',
            'website' => 'https://www.websolutionus.com/',
            'github' => 'https://www.github.com/',
        ]);

        for ($i = 0; $i < 4; $i++) {
            UserExperience::create([
                'user_id' => 1003,
                'company' => $companies[$i],
                'position' => 'Developer',
                'start_date' => now()->subYear(),
                'end_date' => now(),
            ]);
            UserEducation::create([
                'user_id' => 1003,
                'organization' => $educations[$i],
            ]);
        }

        User::create([
            'id' => 1004,
            'first_name' => 'Lucas',
            'last_name' => 'Hale',
            'email' => 'instructorfour@gmail.com',
            'password' => bcrypt('1234'),
            'role' => 'instructor',
            'email_verified_at' => now(),
            'short_bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices',
            'bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.

            developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.

            a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.
            ',
            'job_title' => 'Instructor',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://twitter.com/',
            'linkedin' => 'https://www.linkedin.com/',
            'website' => 'https://www.websolutionus.com/',
            'github' => 'https://www.github.com/',
        ]);

        for ($i = 0; $i < 4; $i++) {
            UserExperience::create([
                'user_id' => 1004,
                'company' => $companies[$i],
                'position' => 'Developer',
                'start_date' => now()->subYear(),
                'end_date' => now(),
            ]);
            UserEducation::create([
                'user_id' => 1004,
                'organization' => $educations[$i],
            ]);
        }

        User::create([
            'id' => 1005,
            'first_name' => 'Nathaniel',
            'last_name' => 'Cross',
            'email' => 'instructorfive@gmail.com',
            'password' => bcrypt('1234'),
            'role' => 'instructor',
            'email_verified_at' => now(),
            'short_bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices',
            'bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.

            developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.

            a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.
            ',
            'job_title' => 'Developer',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://twitter.com/',
            'linkedin' => 'https://www.linkedin.com/',
            'website' => 'https://www.websolutionus.com/',
            'github' => 'https://www.github.com/',
        ]);

        for ($i = 0; $i < 4; $i++) {
            UserExperience::create([
                'user_id' => 1005,
                'company' => $companies[$i],
                'position' => 'Developer',
                'start_date' => now()->subYear(),
                'end_date' => now(),
            ]);
            UserEducation::create([
                'user_id' => 1005,
                'organization' => $educations[$i],
            ]);
        }

        User::create([
            'id' => 1006,
            'first_name' => 'Adrian',
            'last_name' => 'Pierce',
            'email' => 'instructorsix@gmail.com',
            'password' => bcrypt('1234'),
            'role' => 'instructor',
            'email_verified_at' => now(),
            'short_bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices',
            'bio' => 'I am a web developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.

            developer with a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.
            
            a vast array of knowledge in many different front end and back end languages, responsive frameworks, databases, and best code practices. My objective is simply to be the best web developer that I can be and to contribute to the technology industry all that I know and can do. I am dedicated to perfecting my craft by learning from more seasoned developers, remaining humble, and continuously making strides to learn all that I can about development.
            ',
            'job_title' => 'Developer',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://twitter.com/',
            'linkedin' => 'https://www.linkedin.com/',
            'website' => 'https://www.websolutionus.com/',
            'github' => 'https://www.github.com/',
        ]);

        for ($i = 0; $i < 4; $i++) {
            UserExperience::create([
                'user_id' => 1006,
                'company' => $companies[$i],
                'position' => 'Developer',
                'start_date' => now()->subYear(),
                'end_date' => now(),
            ]);
            UserEducation::create([
                'user_id' => 1006,
                'organization' => $educations[$i],
            ]);
        }
    }
}
