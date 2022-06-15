<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FilmTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $countries = [
            "Afghanistan",
            "Albania",
            "Algeria",
            "American Samoa",
            "Andorra",
            "Angola",
            "Anguilla",
            "Antarctica",
            "Antigua and Barbuda",
            "Argentina",
            "Armenia",
            "Aruba",
            "Australia",
            "Austria",
            "Azerbaijan",
            "Bahamas",
            "Bahrain",
            "Bangladesh",
            "Barbados",
            "Belarus",
            "Belgium",
            "Belize",
            "Benin",
            "Bermuda",
            "Bhutan",
            "Bolivia",
            "Bosnia and Herzegowina",
            "Botswana",
            "Bouvet Island",
            "Brazil",
            "British Indian Ocean Territory",
            "Brunei Darussalam",
            "Bulgaria",
            "Burkina Faso",
            "Burundi",
            "Cambodia",
            "Cameroon",
            "Canada",
            "Cape Verde",
            "Cayman Islands",
            "Central African Republic",
            "Chad",
            "Chile",
            "China",
            "Christmas Island",
            "Cocos (Keeling) Islands",
            "Colombia",
            "Comoros",
            "Congo",
            "Congo, the Democratic Republic of the",
            "Cook Islands",
            "Costa Rica",
            "Cote d'Ivoire",
            "Croatia (Hrvatska)",
            "Cuba",
            "Cyprus",
            "Czech Republic",
            "Denmark",
            "Djibouti",
            "Dominica",
            "Dominican Republic",
            "East Timor",
            "Ecuador",
            "Egypt",
            "El Salvador",
            "Equatorial Guinea",
            "Eritrea",
            "Estonia",
            "Ethiopia",
            "Falkland Islands (Malvinas)",
            "Faroe Islands",
            "Fiji",
            "Finland",
            "France",
            "France Metropolitan",
            "French Guiana",
            "French Polynesia",
            "French Southern Territories",
            "Gabon",
            "Gambia",
            "Georgia",
            "Germany",
            "Ghana",
            "Gibraltar",
            "Greece",
            "Greenland",
            "Grenada",
            "Guadeloupe",
            "Guam",
            "Guatemala",
            "Guinea",
            "Guinea-Bissau",
            "Guyana",
            "Haiti",
            "Heard and Mc Donald Islands",
            "Holy See (Vatican City State)",
            "Honduras",
            "Hong Kong",
            "Hungary",
            "Iceland",
            "India",
            "Indonesia",
            "Iran (Islamic Republic of)",
            "Iraq",
            "Ireland",
            "Israel",
            "Italy",
            "Jamaica",
            "Japan",
            "Jordan",
            "Kazakhstan",
            "Kenya",
            "Kiribati",
            "Korea, Democratic People's Republic of",
            "Korea, Republic of",
            "Kuwait",
            "Kyrgyzstan",
            "Lao, People's Democratic Republic",
            "Latvia",
            "Lebanon",
            "Lesotho",
            "Liberia",
            "Libyan Arab Jamahiriya",
            "Liechtenstein",
            "Lithuania",
            "Luxembourg",
            "Macau",
            "Macedonia, The Former Yugoslav Republic of",
            "Madagascar",
            "Malawi",
            "Malaysia",
            "Maldives",
            "Mali",
            "Malta",
            "Marshall Islands",
            "Martinique",
            "Mauritania",
            "Mauritius",
            "Mayotte",
            "Mexico",
            "Micronesia, Federated States of",
            "Moldova, Republic of",
            "Monaco",
            "Mongolia",
            "Montserrat",
            "Morocco",
            "Mozambique",
            "Myanmar",
            "Namibia",
            "Nauru",
            "Nepal",
            "Netherlands",
            "Netherlands Antilles",
            "New Caledonia",
            "New Zealand",
            "Nicaragua",
            "Niger",
            "Nigeria",
            "Niue",
            "Norfolk Island",
            "Northern Mariana Islands",
            "Norway",
            "Oman",
            "Pakistan",
            "Palau",
            "Panama",
            "Papua New Guinea",
            "Paraguay",
            "Peru",
            "Philippines",
            "Pitcairn",
            "Poland",
            "Portugal",
            "Puerto Rico",
            "Qatar",
            "Reunion",
            "Romania",
            "Russian Federation",
            "Rwanda",
            "Saint Kitts and Nevis",
            "Saint Lucia",
            "Saint Vincent and the Grenadines",
            "Samoa",
            "San Marino",
            "Sao Tome and Principe",
            "Saudi Arabia",
            "Senegal",
            "Seychelles",
            "Sierra Leone",
            "Singapore",
            "Slovakia (Slovak Republic)",
            "Slovenia",
            "Solomon Islands",
            "Somalia",
            "South Africa",
            "South Georgia and the South Sandwich Islands",
            "Spain",
            "Sri Lanka",
            "St. Helena",
            "St. Pierre and Miquelon",
            "Sudan",
            "Suriname",
            "Svalbard and Jan Mayen Islands",
            "Swaziland",
            "Sweden",
            "Switzerland",
            "Syrian Arab Republic",
            "Taiwan, Province of China",
            "Tajikistan",
            "Tanzania, United Republic of",
            "Togo",
            "Tokelau",
            "Tonga",
            "Trinidad and Tobago",
            "Tunisia",
            "Turkey",
            "Turkmenistan",
            "Turks and Caicos Islands",
            "Tuvalu",
            "Uganda",
            "Ukraine",
            "United Arab Emirates",
            "United Kingdom",
            "United States",
            "United States Minor Outlying Islands",
            "Uruguay",
            "Uzbekistan",
            "Vanuatu",
            "Venezuela",
            "Vietnam",
            "Virgin Islands (British)",
            "Virgin Islands (U.S.)",
            "Wallis and Futuna Islands",
            "Western Sahara",
            "Yemen",
            "Yugoslavia",
            "Zambia",
            "Zimbabwe"
        ];
        $genre = [
            "Heroic Bloodshed",
            "Military Action",
            "Espionage",
            "Wuxia Action",
            "Disaster",
            "Adventure",
            "Superhero",
            "Traditional",
            "Stop Motion",
            "Claymation",
            "Cutout",
            "Computer Generated Imagery",
            "Puppetry",
            "Live-Action",
            "Action-Comedy",
            "Dark Comedy (Black Comedy)",
            "Romantic Comedy",
            "Buddy Comedy",
            "Road Comedy",
            "Slapstick Comedy",
            "Parody",
            "Sketch Comedy",
            "Prank",
            "Heist",
            "Gangster",
            "Cop (Police)",
            "Detective",
            "Courtroom",
            "Procedural",
            "Ghost",
            "Monster",
            "Werewolf",
            "Vampire",
            "Zombie",
        ];

        $rating = [
            "0.5",
            "1",
            "1.5",
            "2",
            "2.5",
            "3",
            "3.5",
            "4",
            "4.5",
            "5",
        ];

        $movie_names = [
            0 => [
                "name" => 'The Godfather (1972)',
                "image" => "https://static.stacker.com/s3fs-public/styles/slide_desktop/s3/Untitled%20design%20%281%29%209.01.42%20PM.png"
            ],
            1 => [
                "name" => '12 Angry Men (1957)',
                "image" => "https://static.stacker.com/s3fs-public/styles/slide_desktop/s3/00000153_8_0.png"
            ],
            2 => [
                "name" => 'Casablanca (1942)',
                "image" => "https://static.stacker.com/s3fs-public/styles/slide_desktop/s3/Untitled%20design%20%281%29%205.53.02%20PM.png"
            ],
            3 => [
                "name" => 'Rear Window (1954)',
                "image" => "https://static.stacker.com/s3fs-public/styles/slide_desktop/s3/Untitled%20design%20%281%29%205.53.40%20PM.png"
            ],
            4 => [
                "name" => 'City Lights (1931)',
                "image" => "https://static.stacker.com/s3fs-public/styles/slide_desktop/s3/croppedMV5BNTIzODMwODU2NF5BMl5BanBnXkFtZTcwNzY3NzE5NgV1SX1353CR001353999ALjpg.JPEG"
            ],
            5 => [
                "name" => 'Pulp Fiction (1994)',
                "image" => "https://static.stacker.com/s3fs-public/styles/slide_desktop/s3/Untitled%20design%20%281%29%205.50.35%20PM.png"
            ],
            6 => [
                "name" => 'The Lord of the Rings: The Return of the King (2003)',
                "image" => "https://static.stacker.com/s3fs-public/styles/slide_desktop/s3/2021-09/Lord%20of%20the%20Rings%20Return%20of%20the%20King.png"
            ],
            7 => [
                "name" => "Schindler's List (1993)",
                "image" => "https://static.stacker.com/s3fs-public/styles/slide_desktop/s3/Untitled%20design%20%281%29%205.47.08%20PM.png"
            ],
            8 => [
                "name" => "Psycho (1960)",
                "image" => "https://static.stacker.com/s3fs-public/styles/slide_desktop/s3/2021-09/Psycho.png"
            ],
        ];

        for ($i = 0; $i <= 8; $i++) {
            try {
                $user1 = \App\Models\User::factory(1)->create()->first();
                $user2 = \App\Models\User::factory(1)->create()->first();
                $image = $movie_names[$i]['image'];
                $ext = '.' . pathinfo($image, PATHINFO_EXTENSION);
                $path = "uploads/".rand(1111,9999).time().$ext;
                Storage::put($path, file_get_contents($image));
                $film = Film::create([
                    'name' => $movie_names[$i]['name'],
                    'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sollicitudin porttitor massa, et elementum ante congue sit amet. Cras venenatis ex sit amet magna convallis fringilla. Curabitur sit amet quam blandit, rhoncus tellus nec, molestie ligula. Morbi a tortor ex. Suspendisse elementum lobortis arcu, eu finibus lectus facilisis a. Nullam turpis tortor, imperdiet quis dui at, vestibulum eleifend ante. Cras non accumsan velit, at pharetra diam. Morbi dictum bibendum venenatis. Nulla ut neque sit amet odio feugiat gravida. Maecenas felis enim, vestibulum vitae lorem id, imperdiet blandit ex. Nunc est odio, gravida nec convallis nec, consectetur eu nibh. Curabitur sed lobortis tellus. Pellentesque pulvinar turpis elit, sit amet molestie turpis sollicitudin eu. Praesent viverra massa eget fermentum condimentum. Fusce non facilisis magna, ut convallis sapien. Nullam interdum maximus lacus mollis egestas.",
                    'release_date' => now()->format('Y-m-d'),
                    'rating' => $rating[array_rand($rating)],
                    'ticket_price' => rand(111, 999),
                    'country' => $countries[array_rand($countries)],
                    'genre' => $genre[array_rand($genre)].', '.$genre[array_rand($genre)],
                    "photo" => $path
                ]);
                $comment = Comment::create([
                    'film_id' => $film->id,
                    'user_id' => $user1->id,
                    'comment' => 'A new comment.'
                ]);
                $commentReply = Comment::create([
                    'film_id' => $film->id,
                    'user_id' => $user2->id,
                    'comment' => 'A new reply comment.',
                    'comment_id' => $comment->id
                ]);
                $film->comments()->save($comment);
                $film->comments()->save($commentReply);
            } catch (\Throwable $th) {
                dump($i.' index');
                dd($th->getMessage());
            }
        }
    }
}
