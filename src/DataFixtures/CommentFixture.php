<?php
namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixture extends Fixture implements DependentFixtureInterface
{
    const COMMENT_REFERENCE = "COMMENT_";

    public function load(ObjectManager $manager)
    {
        $dog = $this->getReference(UserFixture::USER_REFERENCE);
        
        for ($i = 0; $i < 5; $i++) {
            $post = $this->getReference(PostFixture::POST_REFERENCE . $i);
            $post->setDog($dog);

            $comment = (new Comment())
                ->setCommentText("Hi Hi")
                ->setPost($post)
                ->setDog($dog);
            
            $manager->persist($comment);
            $manager->flush();

            $this->addReference(self::COMMENT_REFERENCE . $i, $comment);
        }
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
            PostFixture::class
        ];
    }
}