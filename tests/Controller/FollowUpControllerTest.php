<?php

namespace App\Test\Controller;

use App\Entity\FollowUp;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FollowUpControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/follow/up/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(FollowUp::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('FollowUp index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'follow_up[contactName]' => 'Testing',
            'follow_up[comment]' => 'Testing',
            'follow_up[callDate]' => 'Testing',
            'follow_up[veterinary]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new FollowUp();
        $fixture->setContactName('My Title');
        $fixture->setComment('My Title');
        $fixture->setCallDate('My Title');
        $fixture->setVeterinary('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('FollowUp');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new FollowUp();
        $fixture->setContactName('Value');
        $fixture->setComment('Value');
        $fixture->setCallDate('Value');
        $fixture->setVeterinary('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'follow_up[contactName]' => 'Something New',
            'follow_up[comment]' => 'Something New',
            'follow_up[callDate]' => 'Something New',
            'follow_up[veterinary]' => 'Something New',
        ]);

        self::assertResponseRedirects('/follow/up/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getContactName());
        self::assertSame('Something New', $fixture[0]->getComment());
        self::assertSame('Something New', $fixture[0]->getCallDate());
        self::assertSame('Something New', $fixture[0]->getVeterinary());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new FollowUp();
        $fixture->setContactName('Value');
        $fixture->setComment('Value');
        $fixture->setCallDate('Value');
        $fixture->setVeterinary('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/follow/up/');
        self::assertSame(0, $this->repository->count([]));
    }
}
