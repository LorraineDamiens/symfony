<?php
namespace App\DataFixtures;

use Faker;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        'Season 1' => [
            'program'    => 'program_0',
            'year'    => '1980',
        ],
        'Season 2' => [
            'program'    => 'program_0',
            'year'    => '1990',
        ],
        'Season 3' => [
            'program'    => 'program_0',
            'year'    => '2000',
        ],
    ];
    public function load(ObjectManager $manager)
    {
        $i=0;
        foreach (self::SEASONS as $description => $data){
            $season = new Season();
            $season->setDescription($description);
            $season->setYear($data['year']);
            $manager->persist($season);
            $season->setProgram($this->getReference('program_0'));
            $i++;
        }

        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 147; $i++) {
            $season = new season();
            $season->setDescription('Season : '.$faker->sentence);
            $season->setYear($faker->year);
            $manager->persist($season);
            $this->addReference('season_' . $i, $season);
            $season->setProgram($this->getReference('program_'.rand(0, 5)));
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}