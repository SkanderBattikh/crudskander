<?php

namespace App\DataFixtures;

use App\Entity\Employes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class EmployesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 5; $i++){
            $employe = new Employes();
            $employe->setPrenom("eqcce");
            $employe->setNom("efezfrz");
            $employe->setTelephone(23456);
            $employe->setEmail("segzrgz@rjebe.fbd");
            $employe->setAdresse("rgertete");
            $employe->setPoste("poste n°$i");
            $employe->setSalaire(23565);
            $employe->setDatedenaissance("01/12/2001");

            $manager->persist($employe);
        }

        $manager->flush();
    }
}
