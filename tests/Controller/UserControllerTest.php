<?php

namespace App\Test\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/profil/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(User::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'user[email]' => 'Testing',
            'user[roles]' => 'Testing',
            'user[password]' => 'Testing',
            'user[name]' => 'Testing',
            'user[lastname]' => 'Testing',
            'user[birthday]' => 'Testing',
            'user[city]' => 'Testing',
            'user[car]' => 'Testing',
            'user[handicap]' => 'Testing',
            'user[presentation]' => 'Testing',
            'user[activities]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new User();
        $fixture->setEmail('My Title');
        $fixture->setRoles('My Title');
        $fixture->setPassword('My Title');
        $fixture->setName('My Title');
        $fixture->setLastname('My Title');
        $fixture->setBirthday('My Title');
        $fixture->setCity('My Title');
        $fixture->setCar('My Title');
        $fixture->setHandicap('My Title');
        $fixture->setPresentation('My Title');
        $fixture->setActivities('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new User();
        $fixture->setEmail('Value');
        $fixture->setRoles('Value');
        $fixture->setPassword('Value');
        $fixture->setName('Value');
        $fixture->setLastname('Value');
        $fixture->setBirthday('Value');
        $fixture->setCity('Value');
        $fixture->setCar('Value');
        $fixture->setHandicap('Value');
        $fixture->setPresentation('Value');
        $fixture->setActivities('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'user[email]' => 'Something New',
            'user[roles]' => 'Something New',
            'user[password]' => 'Something New',
            'user[name]' => 'Something New',
            'user[lastname]' => 'Something New',
            'user[birthday]' => 'Something New',
            'user[city]' => 'Something New',
            'user[car]' => 'Something New',
            'user[handicap]' => 'Something New',
            'user[presentation]' => 'Something New',
            'user[activities]' => 'Something New',
        ]);

        self::assertResponseRedirects('/profil/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getRoles());
        self::assertSame('Something New', $fixture[0]->getPassword());
        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getLastname());
        self::assertSame('Something New', $fixture[0]->getBirthday());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getCar());
        self::assertSame('Something New', $fixture[0]->getHandicap());
        self::assertSame('Something New', $fixture[0]->getPresentation());
        self::assertSame('Something New', $fixture[0]->getActivities());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new User();
        $fixture->setEmail('Value');
        $fixture->setRoles('Value');
        $fixture->setPassword('Value');
        $fixture->setName('Value');
        $fixture->setLastname('Value');
        $fixture->setBirthday('Value');
        $fixture->setCity('Value');
        $fixture->setCar('Value');
        $fixture->setHandicap('Value');
        $fixture->setPresentation('Value');
        $fixture->setActivities('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/profil/');
        self::assertSame(0, $this->repository->count([]));
    }
}