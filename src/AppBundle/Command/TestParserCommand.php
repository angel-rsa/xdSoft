<?php

namespace AppBundle\Command;

use AppBundle\Entity\Top;
use AppBundle\Entity\TopItem;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class TestParserCommand extends ContainerAwareCommand
{
    private $url = 'https://www.kinopoisk.ru/top/';

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var array
     */
    private $parsedItems = [];

    protected function configure()
    {
        $this
            ->setName('parse:kinopoisk')
            ->addArgument('date', InputArgument::OPTIONAL, 'Дата в формате Y-m-d')
            ->setDescription('Парсинг топа сайта kinopoisk.ru');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $date = new \DateTime();

        if ($inputDate = $input->getArgument('date')) {
            $date = \DateTime::createFromFormat('Y-m-d', $inputDate);
            $this->url .= 'day/' .$date->format('Y-m-d') . '/';
        }

        try {
            $html = file_get_contents($this->url);
        } catch (\Exception $e) {
            $output->writeln('Can not get page content from ' . $this->url);
            return 1;
        }

        return $this->parseTop($date, new Crawler($html));
    }

    /**
     * Парсинг страницы с топом
     * @param \DateTime $date
     * @param Crawler $crawler
     * @return int
     */
    private function parseTop(\DateTime $date, Crawler $crawler)
    {
        try {
            $header = trim($crawler->filter('h1.main_title')->first()->text());
        } catch (\Exception $e) {
            $header = '';
        }

        $header = preg_replace('/\n/', ' ', $header);
        $header = preg_replace('/\s+/', ' ', $header);

        $crawler->filter('div.block_left table table table tr')->each(function (Crawler $node) {
            $this->parseTopItem($node);
        });

        if (empty($this->parsedItems)) {
            $this->output->writeln('No items parsed');
            return 2;
        }

        return $this->saveTop($date, $header);
    }

    /**
     * Парсинг одной позиции топа
     * @param Crawler $node
     * @return array
     */
    private function parseTopItem(Crawler $node)
    {
        if (preg_match('/^top250_place_(\d+)$/', $node->attr('id'), $matches)) {
            $item = [
                'position' => (int) $matches[1],
                'name' => '',
                'originalName' => '',
                'year' => null,
                'rating' => null,
                'voters' => null,
            ];

            try {
                $name = $node->filter('td')->eq(1)->filter('a.all')->text();

                if (preg_match('/^(.+) \((\d+)\)$/', $name, $matches)) {
                    $item['name'] = $matches[1];
                    $item['year'] = $matches[2];
                }
            } catch (\Exception $e) {}

            try {
                $item['originalName'] = $node->filter('td')->eq(1)->filter('span.text-grey')->text();
            } catch (\Exception $e) {
                $item['originalName'] = $item['name'];
            }

            try{
                $item['rating'] = (float) $node->filter('td')->eq(2)->filter('div a.continue')->text();
            } catch (\Exception $e) {
                $item['rating'] = null;
            }

            try{
                $item['voters'] = $node->filter('td')->eq(2)->filter('div span')->text();
                $item['voters'] = (int) preg_replace('/\D/', '', $item['voters']);
            } catch (\Exception $e) {
                $item['voters'] = null;
            }

            return $this->parsedItems[] = $item;
        }

        return [];
    }

    /**
     * Сохранение топа в БД
     * @param \DateTime $date
     * @param string $header
     * @return int
     */
    private function saveTop(\DateTime $date, $header)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $top = $em->getRepository(Top::class)->findOneBy(['date' => $date]);

        if ($top) {
            $em->remove();
            $em->flush();
        }

        $newTop = (new Top())
            ->setDate($date)
            ->setTitle($header);
        $em->persist($newTop);

        foreach($this->parsedItems as $item) {
            $newItem = (new TopItem())
                ->setPosition($item['position'])
                ->setName($item['name'])
                ->setOriginalName($item['originalName'])
                ->setRating($item['rating'])
                ->setVoters($item['voters'])
                ->setYear($item['year'])
                ->setTop($newTop);

            $em->persist($newItem);
            $newTop->addItem($newItem);
        }

        $em->flush();

        return 0;
    }
}