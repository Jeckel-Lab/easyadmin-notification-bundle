# EasyAdmin notification bundle

Symfony Notification Bundle for EasyAdmin bundle

### Doctrine additional config:

```yaml
doctrine:
    dbal:
        types:
            notification_level: JeckelLab\NotificationBundle\DBAL\Types\NotificationLevelType
```

### Easy admin sample configuration:
```yaml
easy_admin:
    design:
        templates:
            layout: '@JeckelLabNotification/layouts/layout.html.twig'
    entities:
        Notification:
            translation_domain: 'JeckelLabNotification'
            class: JeckelLab\NotificationBundle\Entity\Notification
            controller: JeckelLab\NotificationBundle\Controller\NotificationController
            disabled_actions: ['edit', 'new']
            list:
                batch_actions: ['delete', 'markRead']
                fields:
                    - { property: level, label: notification.level, template: '@JeckelLabNotification/field/notification_level.html.twig' }
                    - { property: source, label: notification.source }
                    - { property: message, label: notification.message }
                    - { property: send_at, label: notification.send_at }
                    - { property: read_at, label: notification.read_at }
                sort: ['send_at', 'DESC']
                filters:
                    - { property: source, label: notification.source }
                    - { property: read_at, label: notification.read_at, type: date }
            show:
                fields:
                    - { property: level, label: notification.level, template: '@JeckelLabNotification/field/notification_level.html.twig' }
                    - { property: source, label: notification.source }
                    - { property: message, label: notification.message }
                    - { property: send_at, label: notification.send_at }
```
