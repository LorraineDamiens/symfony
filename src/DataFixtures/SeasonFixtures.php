<?php
namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        'Season 1' => [
            'program'    => 'program_0',
            'year'    => '2010',
        ],
        'Season 2' => [
            'program'    => 'program_0',
            'year'    => '2011',
        ],
        'Season 3' => [
            'program'    => 'program_0',
            'year'    => '2012',
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
        $manager->flush();
    }
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}