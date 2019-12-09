<?php

namespace App\DataFixtures;

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

        foreach (self::ACTORS as $name => $data) {
            $actor = new Actor();
            $actor->setName($name);
            $manager->persist($actor);
            $actor->addProgram($this->getReference($data['program']));
        }
        $manager->flush();
    }
        public function getDependencies()
        {
            return [ProgramFixtures::class];
        }
    }