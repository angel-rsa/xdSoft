<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestParserCommand extends ContainerAwareCommand
{
    const BASE_URL = 'https://www.kinopoisk.ru/top/';


    protected function configure()
    {
        $this
            ->setName('parse:kinopoisk')
            ->addArgument('date', InputArgument::OPTIONAL, 'Дата в формате Y-m-d')
            ->setDescription('Парсинг топа сайта kinopoisk.ru');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date = $input->getArgument('date');
    }
}