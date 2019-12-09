<?php
namespace App\DataFixtures;

use Faker;
use App\Entity\Episode;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODES = [
        'Episode 1' => [
            'title'    => 'super episode',
            'season'    => 'season_0',
            'number'    => '1',
            'synopsis'    => 'il se passe plein de choses trop sympas',
        ],
        'Episode 2' => [
            'title'    => 'top episode',
            'season'    => 'season_0',
            'number'    => '2',
            'synopsis'    => 'celui la fait très très peur',
        ],
        'Episode 3' => [
            'title'    => 'episode pas mal',
            'season'    => 'season_0',
            'number'    => '3',
            'synopsis'    => 'on rit aux éclats',
        ],
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::EPISODES as $title => $data){
            $episode = new episode();
            $episode->setTitle($title);
            $episode->setNumber($data['number']);
            $episode->setSynopsis($data['synopsis']);
            $manager->persist($episode);
            $episode->setSeason($this->getReference('season_0'));
        }
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 147; $i++) {
            $episode = new episode();
            $episode->setTitle($faker->sentence);
            $episode->setNumber($faker->numberBetween(1,3));
            $episode->setSynopsis($faker->text);
            $manager->persist($episode);
            $episode->setSeason($this->getReference('season_' . rand(0, 146)));
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}


