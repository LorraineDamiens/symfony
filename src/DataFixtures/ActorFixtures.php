<?php
namespace App\DataFixtures;

use Faker;
use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Self_;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'Andrew Lincoln' => [
            'program'    => 'program_0',
        ],
        'Norman Reedus' => [
            'program'    => 'program_0',
        ],
        'Lauren Cohan' => [
            'program'    => 'program_0',
        ],
        'Danai Gurira' => [
            'program'    => 'program_0',
        ],
        'Peter Crouch' => [
            'program'    => 'program_0',
        ],
    ];
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 45; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $manager->persist($actor);
            $actor->addProgram($this->getReference('program_' . rand(0, 5)));
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
