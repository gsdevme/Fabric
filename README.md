# Fabric (WIP)

[![Build Status](https://travis-ci.org/gsdevme/Fabric.svg?branch=master)](https://travis-ci.org/gsdevme/Fabric)
[![Coverage Status](https://coveralls.io/repos/github/gsdevme/Fabric/badge.svg?branch=master)](https://coveralls.io/github/gsdevme/Fabric?branch=master)

Fabric is a set of interfaces, traits and simple classes to help structure libraries and code that interact with APIs.

## Concept / Api

In the following example we are getting the git repositories for a user.

```
$response = (new Client())->send(new GetRepositoriesForUser($userId));
```


### Features

1. PSR-7 Friendly (Guzzle Implementation (guzzlehttp/psr7)
2. Default Client (via guzzlehttp/guzzle)
