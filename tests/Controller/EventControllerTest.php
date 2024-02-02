<?php

namespace App\Test\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/event/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Event::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Event index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'event[title]' => 'Testing',
            'event[duration]' => 'Testing',
            'event[start_date]' => 'Testing',
            'event[end_date]' => 'Testing',
            'event[location]' => 'Testing',
            'event[description]' => 'Testing',
            'event[Logistic]' => 'Testing',
            'event[user]' => 'Testing',
            'event[activities]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Event();
        $fixture->setTitle('My Title');
        $fixture->setDuration('My Title');
        $fixture->setStart_date('My Title');
        $fixture->setEnd_date('My Title');
        $fixture->setLocation('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLogistic('My Title');
        $fixture->setUser('My Title');
        $fixture->setActivities('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Event');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Event();
        $fixture->setTitle('Value');
        $fixture->setDuration('Value');
        $fixture->setStart_date('Value');
        $fixture->setEnd_date('Value');
        $fixture->setLocation('Value');
        $fixture->setDescription('Value');
        $fixture->setLogistic('Value');
        $fixture->setUser('Value');
        $fixture->setActivities('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'event[title]' => 'Something New',
            'event[duration]' => 'Something New',
            'event[start_date]' => 'Something New',
            'event[end_date]' => 'Something New',
            'event[location]' => 'Something New',
            'event[description]' => 'Something New',
            'event[Logistic]' => 'Something New',
            'event[user]' => 'Something New',
            'event[activities]' => 'Something New',
        ]);

        self::assertResponseRedirects('/event/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDuration());
        self::assertSame('Something New', $fixture[0]->getStart_date());
        self::assertSame('Something New', $fixture[0]->getEnd_date());
        self::assertSame('Something New', $fixture[0]->getLocation());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getLogistic());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getActivities());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Event();
        $fixture->setTitle('Value');
        $fixture->setDuration('Value');
        $fixture->setStart_date('Value');
        $fixture->setEnd_date('Value');
        $fixture->setLocation('Value');
        $fixture->setDescription('Value');
        $fixture->setLogistic('Value');
        $fixture->setUser('Value');
        $fixture->setActivities('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/event/');
        self::assertSame(0, $this->repository->count([]));
    }
}
