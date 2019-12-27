# [Work In Progress] notification-bundle
Symfony Notification Bundle

Sample configuration

```yaml
        Notification:
            class: JeckelLab\NotificationBundle\Entity\Notification
            controller: App\Bundle\NotificationBundle\Controller\NotificationController
            disabled_actions: ['edit', 'new']
            list:
                batch_actions: ['delete', 'markRead']
                fields:
                    - { property: 'level', template: 'admin/notification_level.html.twig' }
                    - source
                    - message
                    - send_at
                    - read_at
                sort: ['send_at', 'DESC']
                filters:
                    - source
                    - { property: 'read_at', type: 'date' }
            show:
                fields:
                    - { property: 'level', template: 'admin/notification_level.html.twig' }
                    - source
                    - message
                    - send_at
```
