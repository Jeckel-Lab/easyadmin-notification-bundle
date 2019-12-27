# [Work In Progress] notification-bundle
Symfony Notification Bundle

Sample configuration

```yaml
        Notification:
            translation_domain: 'JeckelLabEasyAdminNotification'
            class: JeckelLab\NotificationBundle\Entity\Notification
            controller: JeckelLab\NotificationBundle\Controller\NotificationController
            disabled_actions: ['edit', 'new']
            list:
                batch_actions: ['delete', 'markRead']
                fields:
                    - { property: level, label: 'notification.level', template: 'admin/notification_level.html.twig' }
                    - { property: source, label: 'notification.source' }
                    - { property: message, label: notification.message }
                    - { property: send_at, label: notification.send_at }
                    - { property: read_at, label: notification.read_at }
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
