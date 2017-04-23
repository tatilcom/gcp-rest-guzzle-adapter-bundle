### Symfony Bundle built-on Guzzle for Google Cloud Platform REST APIs

##### Use Case
Accessing to Google Cloud Platform Rest APIs using Service Account Credentials (Google's recommended way) 

For more information about authentication: https://cloud.google.com/speech/docs/common/auth

#### Usage 

###### Configuration
```yaml
gcp_rest_guzzle_adapter:
    clients:
        pubsub:
            email: 'test@test.com'
            private_key: '-----BEGIN PRIVATE KEY-----SDADAavaf...-----END PRIVATE KEY-----'
            scope: 'https://www.googleapis.com/auth/pubsub'
            project_base_url: 'https://pubsub.googleapis.com/v1/projects/test-project123/'

```

###### Accessing Service by container
```php
$pubSubClient = $container->get('gcp_rest_guzzle_adapter.client.pubsub_client');

$result = $pubSubClient->get(
    sprintf('topics/%s/subscriptions', 'test-topic')
);

var_dump((string)$result->getBody()->getContents());
```

###### Result
```php
string(113) "{
  "subscriptions": [
    "projects/test-project123/subscriptions/test_topicSubscriber"
  ]
}
"
```