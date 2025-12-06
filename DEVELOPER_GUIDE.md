# Developer guide

We're glad you're interested in contributing to our project! This guide will help you get started with the development
process.

## Getting Started

[Fork the repository](https://docs.github.com/en/pull-requests/collaborating-with-pull-requests/working-with-forks/fork-a-repo)
and [clone it](https://docs.github.com/en/repositories/creating-and-managing-repositories/cloning-a-repository) to your
local machine.

### Prerequisites

The preferred way is to use [Docker](https://www.docker.com/get-started) and Make.

Alternatively, ensure you have the following installed:

- **PHP**: You can know which version is required by checking the `composer.json` file.
- **Composer**: Dependency manager for PHP. [Get Composer](https://getcomposer.org/download/)

### Starting the Development Environment

If you're using Docker & Make, simply run:

```bash
make start
```

This command will build the docker image, start the container, and take you inside the container bash shell so that you
can directly run commands.

### Installing Dependencies

Inside the docker container or your local environment, run:

```bash
composer install
```

### Running Code Quality Tools

To ensure the code quality and CI compliance, we are using the following tools:

#### PHPUnit for testing

To run the full test suite, execute:

```bash
composer test
```

#### PHP CS-Fixer for code style

To check and fix code style issues, run:

```bash
composer cs-fix
```

#### Psalm for static analysis

To perform static analysis, run:

```bash
composer psalm
```

## Code Contribution Guidelines

When this project was started by [Dhemy](https://github.com/imdhemy), like any developer, the initial codebase reflected
his own coding style and
preferences. Over time, more knowledge and experience were acquired; additionally, PHP itself evolved. As a result, the
codebase might reflect a mix of styles and practices.

Currently, we are following the principles
of [Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html).
See [this issue](https://github.com/imdhemy/google-play-billing/issues/236) for the current state of the codebase and
the planned improvements.

## Pick your work

The best way to start contributing is to check the issues list. Pick an issue that interests you and start working on
it. If you didn't find any issue, you can always propose new features or improvements by opening a new issue.

## Weekly meeting

We have a weekly meeting every Friday at 16:00 Berlin time. Feel free to join us
on [Google Meet](https://meet.google.com/zgo-wtpp-jfh) to discuss the ongoing
work and any questions you might have.
