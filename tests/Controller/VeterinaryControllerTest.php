<?php

namespace App\Test\Controller;

use App\Entity\Veterinary;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VeterinaryControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/veterinary/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Veterinary::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Veterinary index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'veterinary[name]' => 'Testing',
            'veterinary[address]' => 'Testing',
            'veterinary[postalCode]' => 'Testing',
            'veterinary[city]' => 'Testing',
            'veterinary[phonep]' => 'Testing',
            'veterinary[imageFileName]' => 'Testing',
            'veterinary[creationDate]' => 'Testing',
            'veterinary[activities]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Veterinary();
        $fixture->setName('My Title');
        $fixture->setAddress('My Title');
        $fixture->setPostalCode('My Title');
        $fixture->setCity('My Title');
        $fixture->setPhonep('My Title');
        $fixture->setImageFileName('My Title');
        $fixture->setCreationDate('My Title');
        $fixture->setActivities('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Veterinary');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Veterinary();
        $fixture->setName('Value');
        $fixture->setAddress('Value');
        $fixture->setPostalCode('Value');
        $fixture->setCity('Value');
        $fixture->setPhonep('Value');
        $fixture->setImageFileName('Value');
        $fixture->setCreationDate('Value');
        $fixture->setActivities('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'veterinary[name]' => 'Something New',
            'veterinary[address]' => 'Something New',
            'veterinary[postalCode]' => 'Something New',
            'veterinary[city]' => 'Something New',
            'veterinary[phonep]' => 'Something New',
            'veterinary[imageFileName]' => 'Something New',
            'veterinary[creationDate]' => 'Something New',
            'veterinary[activities]' => 'Something New',
        ]);

        self::assertResponseRedirects('/veterinary/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getAddress());
        self::assertSame('Something New', $fixture[0]->getPostalCode());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getPhonep());
        self::assertSame('Something New', $fixture[0]->getImageFileName());
        self::assertSame('Something New', $fixture[0]->getCreationDate());
        self::assertSame('Something New', $fixture[0]->getActivities());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Veterinary();
        $fixture->setName('Value');
        $fixture->setAddress('Value');
        $fixture->setPostalCode('Value');
        $fixture->setCity('Value');
        $fixture->setPhonep('Value');
        $fixture->setImageFileName('Value');
        $fixture->setCreationDate('Value');
        $fixture->setActivities('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/veterinary/');
        self::assertSame(0, $this->repository->count([]));
    }
}
