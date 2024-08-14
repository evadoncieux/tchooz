<?php

namespace App\Tests\Security;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EmailVerifierTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();

        $container = static::getContainer();

        $em = $container->get('doctrine.orm.entity_manager');
        $userRepository = $em->getRepository(User::class);

        // Remove any existing users from the test database
        foreach ($userRepository->findAll() as $user) {
            $em->remove($user);
        }

        $em->flush();

        // Create a User fixture
        /** @var UserPasswordHasherInterface $passwordHasher */
        $passwordHasher = $container->get('security.user_password_hasher');

        $user = (new User())->setEmail('email@example.com')
            ->setUsername('username')
            ->setVerified(false);
        $user->setPassword($passwordHasher->hashPassword($user, 'password'));

        $em->persist($user);
        $em->flush();
    }

    public function testSendEmailConfirmation()
    {
        $this->client->request('GET', '/verify-email');
        self::assertResponseIsSuccessful();

        // from the symfony doc, à adapter au projet
        $this->assertEmailCount(1); // use assertQueuedEmailCount() when using Messenger

        $email = $this->getMailerMessage();

        $this->assertEmailHtmlBodyContains($email, 'Welcome');
        $this->assertEmailTextBodyContains($email, 'Welcome');
    }
}
