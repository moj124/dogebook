<?php

namespace App\Service;

use App\Entity\Dog;
use App\Repository\NotificationRepository;

class NotificationService 
{
    private NotificationRepository $notificationRepo;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepo = $notificationRepository;
    }

    public function getDogsNotifications(Dog $dog)
    {
        return $this->notificationRepo->findAllNotificationsForDog($dog);
    }
}
