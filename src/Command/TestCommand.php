<?php

namespace App\Command;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Post;


#[AsCommand(
    name: 'Test',
    description: 'This is command for test_project',
)]
class TestCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }
    
         public function __construct(private readonly EntityManagerInterface $em,
         private readonly HttpClientInterface $client, string $name = null)
    {
         parent::__construct($name);
    }

    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
       
        $allUsersResponse = $this->client->request('GET', 'https://jsonplaceholder.typicode.com/users');
        $allUsersRaw = $allUsersResponse->toArray();
        
        $usersInfo = [];
        foreach ($allUsersRaw as $user) {
            $usersInfo[$user['id']] = $user['name'];
        }
        
        
        $allPostsResponse = $this->client->request('GET', 'https://jsonplaceholder.typicode.com/posts');
        $allPostsRaw = $allPostsResponse->toArray();
        
        
       
        
            
            $this->em->wrapInTransaction(function(EntityManagerInterface $em) use ($allPostsRaw, $usersInfo) {
                foreach ($allPostsRaw as $postRaw) {
                    $post = new Post();
                    $post->setBody($postRaw['body']);
                    $post->setTitle($postRaw['title']);
                    $post->setUserName($usersInfo[$postRaw['userId']]);
 
                    $this->em->persist($post);
                }
            });
            
            return self::SUCCESS;
        
    }

    

    
}
