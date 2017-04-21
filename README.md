# Fabric (WIP)

Fabric is a set of interfaces, traits and simple classes to help structure libraries and code that interact with APIs.

## Concept / Api

In the following example we are getting the git repositories for a user.

```
$response = (new Client())->send(new GetRepositoriesForUser($userId));
```


### Features

1. PSR-7 Friendly (Guzzle Implementation (guzzlehttp/psr7)
2. Default Client (via guzzlehttp/guzzle)
