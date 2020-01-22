<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\GeneralChatClub;
use App\Entity\ParticipationLike;
use App\Entity\ProfilClub;
use App\Entity\ProfilSolo;
use App\Entity\Sport;
use App\Entity\SportCategory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class AppFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('en_US');

        // Creating admin user
        $admin = new User();
        $admin->setEmail('admin@gruppetto.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'adminpassword'
        ));

        $manager->persist($admin);

        // Creating cluber user : run team
        $cluber = new User();
        $cluber->setEmail('run-team@club.com');
        $cluber->setRoles(['ROLE_CLUBER']);
        $cluber->setPassword($this->passwordEncoder->encodePassword(
            $cluber,
            'clubpassword'
        ));
        $manager->persist($cluber);

        // Creating cluber user : swim team
        $cluber2 = new User();
        $cluber2->setEmail('swim-team@club.com');
        $cluber2->setRoles(['ROLE_CLUBER']);
        $cluber2->setPassword($this->passwordEncoder->encodePassword(
            $cluber2,
            'clubpassword'
        ));
        $manager->persist($cluber2);

        // Fixtures for profil -(//
        $profilClub = new ProfilClub();
        $profilClub->setNameClub('Run Team');
        $profilClub->setCityClub('Lille');
        $profilClub->setLogoClub('avatar2.jpg');
        $profilClub->setDescriptionClub('Petite equipe Lilloise');
        $profilClub->addUser($cluber);
        $manager->persist($profilClub);

        $profilClub2 = new ProfilClub();
        $profilClub2->setNameClub('Swim Team');
        $profilClub2->setCityClub('Douai');
        $profilClub2->setLogoClub('avatar6.jpg');
        $profilClub2->setDescriptionClub('Club de natation');
        $manager->persist($profilClub2);

        // Fixtures for profil Solo//
        $profilSolo = new ProfilSolo();
        $profilSolo->setLastname('Doe');
        $profilSolo->setFirstname('Jonh');
        $profilSolo->setBirthdate(new\ DateTime(141220));
        $profilSolo->setDescription('My description');
        $profilSolo->setGender(0);
        $profilSolo->setAvatar('avatar.jpg');
        $profilSolo->setEmergencyContactName('Pascale Dino');
        $profilSolo->setLevel(1);
        $profilSolo->setSportFrequency(2);
        $profilSolo->setPhone('0000000000');
        $profilSolo->setEmergencyPhone('0000000000');
        $manager->persist($profilSolo);

        $users = [];
        // Creating lambda user
        $user = new User();
        $user->setProfilSolo($profilSolo);
        $user->setEmail('john-doe@msn.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'userpassword'
        ));
        $manager->persist($user);
        $users[] = $user;

        // Fixtures for sportCategory//
        $sportCategory = new SportCategory();
        $sportCategory->setNameCategory('Running');
        $manager->persist($sportCategory);

        // Fixtures for sport//
        $sport = new Sport();
        $sport->setSportName('Courses');
        $sport->setSportCategory($sportCategory);
        $manager->persist($sport);

        // Fixtures for event page//
        $event = new Event();
        $event->setNameEvent('Entrainement de course ');
        $event->setLevelEvent(1);
        $event->setDateEvent($faker->dateTimeThisMonth);
        $event->setTimeEvent($faker->dateTimeThisMonth);
        $event->setDescription('Courses dans la nature');
        $event->setParticipantLimit('10');
        $event->setPlaceEvent('23 place des ecoliers 59000 Lille');
        $event->setSport($sport);
        $event->setCreatorClub($profilClub);
        $manager->persist($event);

        // Fixtures for GeneralChatClub
        $messageClub = new GeneralChatClub();
        $messageClub->setProfilClub($profilClub2);
        $messageClub->setDateMessage(new DateTime('now'));
        $messageClub->setContentMessage('Bonjour, je suis un club de natation');
        $manager->persist($messageClub);


        //participation
        for ($j = 0; $j < mt_rand(0, 10); $j++) {
            $participationLike = new ParticipationLike();

            $participationLike->setEvent($event)
                ->setUser($faker->randomElement($users));
            $manager->persist($participationLike);


            $manager->flush();
        }
    }
}
