<!-- omit in toc -->
# Contributing to PHPUnit Filesystem Assertions

Thank you for taking the time to contribute!

All types of contributions are encouraged and valued. See the [Table of Contents](#table-of-contents) for different ways to help and details about how this project handles them. Please make sure to read the relevant section before making your contribution. It will make things a lot easier for maintainers and improve the experience for everyone.

> If you like this project but don't have time to contribute directly there are other easy ways to support it and show your appreciation:
> - Star the repository
> - Use `bebat/filesystem-assertions` in your own project
> - Share it on social media
> - Mention this library at local meetups and tell your friends/colleagues

<!-- omit in toc -->
## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Questions](#questions)
- [Submitting an Issue](#submitting-an-issue)
  - [Reporting Bugs](#reporting-bugs)
  - [Suggesting Enhancements](#suggesting-enhancements)
- [Contributing Code](#contributing-code)
  - [Development Setup](#development-setup)
  - [Creating a Pull Request](#creating-a-pull-request)

## Code of Conduct

This project and everyone participating in it is governed by the [Contributor Covenant Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code. Please report unacceptable behavior to <ben.batschelet@gmail.com>.

## Questions

If you have any questions about PHPUnit Filesystem Assertions the first, best place to check is the project [documentation](README.md). If your question is not addressed by the existing documentation it may be useful to search for any existing [issues](https://github.com/bbatsche/filesystem-assertions/issues) related to your question. If you find a suitable issue but still need clarification, you may write your question as a comment to that issue.

If you feel your question is still not properly address, please do the following:

1. Open a new [issue](https://github.com/bbatsche/filesystem-assertions/issues/new).
2. Provide as much context as you can about what you're experiencing.
3. Be sure to include relevant environment details, such as PHP and PHPUnit Filesystem Assertions versions.

## Submitting an Issue

### Reporting Bugs

<!-- omit in toc -->
#### Before Submission

There are several steps you can do before reporting a bug that will make fixing the issue quicker and easier for maintainers, or could lead to your issue being resolved without creating a bug report at all.

- Make sure that you are using the latest versions of PHPUnit Filesystem Assertions and all of its dependencies.
- Check the [documentation](README.md) to see if your issue is addressed there.
- Search [existing issues](https://github.com/bbatsche/filesystem-assertions/issues) for your problem. If an issue already exists feel free to give it a `+1` and/or add additional context.
- Collect any relevant information about your issue:
  - OS version & platform (Windows, Linux, macOS, x86, ARM, etc)
  - Web server & PHP version (nginx, Apache, etc)
  - Any relevant input & output
    - Especially any exception output & stacktraces
  - Can you consistently reproduce the issue?
  - Has the behavior changed between versions?

<!-- omit in toc -->
> #### Security Issues
>
> You must never report security related issues, vulnerabilities, or bugs including sensitive information to the issue tracker, or elsewhere in public. Instead, sensitive bugs must be sent via email to <ben.batschelet@gmail.com>. See the [Security Policy](SECURITY.md) for more details.

<!-- omit in toc -->
#### Creating a Bug Report

We use GitHub issues to track bugs and errors. If you run into an issue with the project:

1. Open a [Bug Report Issue](https://github.com/bbatsche/filesystem-assertions/issues/new?labels=bug&template=bug_report.yml&title=%5BBug%5D%3A+)
2. Fill out all the relevant fields in the form
3. Please provide as much context as possible, this usually includes your code. Ideally you should isolate the problem and create a simplified test case.

Once your issue is filed the maintainers will do our best to reproduce the problem, determine the appropriate course of action, and resolve the issue in a timely manner.

### Suggesting Enhancements

If you have an idea on how to improve PHPUnit Filesystem Assertions we are eager to hear it! We welcome any constructive suggestions for improvements to the project and look forward to hearing them.

<!-- omit in toc -->
#### Before Submission

- Make sure that you are using the latest versions of PHPUnit Filesystem Assertions and all its dependencies.
- Check the project [documentation](README.md) to see if your idea has already been implemented.
- Search the [existing issues](https://github.com/bbatsche/filesystem-assertions/issues) to see if the enhancement has already been suggested. If an issue already exists feel free to give it a `+1` and/or add additional context.
- Find out whether your idea fits with the scope and aims of the project. Ideally new features should be useful to a broad set of users and/or streamline something that would otherwise be highly complex. We cannot add features just for their own sake.

<!-- omit in toc -->
#### Creating a Feature Request

1. Open a [Feature Request](https://github.com/bbatsche/filesystem-assertions/issues/new?labels=feature&template=feature_request.yml&title=%5BFeature%5D%3A+)
2. Fill out the relevant fields on the form
  - In the description be sure to include why this feature is important, what use cases will it have, how will it improve people's experiences using the library, etc.
  - Include as many examples as you think are relevant. Be sure to consider edge cases and error conditions as well.
  - Try to estimate whether this feature will require a major or minor version change to the library. In general, if a feature breaks or replaces some already existing functionality it will require a major change, otherwise it will be added to a minor (or possibly patch) release.

## Contributing Code

> ### Notice <!-- omit in toc -->
> When contributing to this project, you affirm that you have authored 100% of the content, that you have the necessary rights to the content and that the content you contribute may be provided under the project's [license](LICENSE).

We are thrilled you would like to contribute code to PHPUnit Filesystem Assertions! This is truly one of the best ways to help support our project and the open source community as a whole. Before writing code for the library, we ask that you consider a few things.

- Is this feature or bug fix needed? Opening a pull request to https://github.com/bbatsche/filesystem-assertions is no guarantee that it will be accepted and merged. If you are not certain whether your contribution will be useful open a [bug report](#creating-a-bug-report) or [feature request](#creating-a-feature-request) first to discuss it with maintainers.
- Will this change affect or break existing functionality? If there is some functionality being removed it will first need to be deprecated in the next minor release and only then can the new functionality be added, targeting the next major version.
- Will this break compatibility with previous versions of PHP? PHPUnit Filesystem Assertions has a long tail of support which is a double edged sword. If your feature is worthwhile it may be added in to the next major release when the minimum version of PHP can be updated.

### Development Setup

There is minimal tooling required to contribute to PHPUnit Filesystem Assertions. In general the software required to write code for this library is the same as it is to use it, ie:

- PHP 7.4 or greater
- Git
- Composer
- A text editor and terminal of your choice.

To get started, follow the steps below:

1. Fork https://github.com/bbatsche/filesystem-assertions to your own profile
2. Clone your fork locally
3. Create a new branch for your work
   - If you are working on a previous version of the library be sure to branch off of the correct version branch.
4. Run `composer install`
5. Begin your work!

In order to ensure code quality and consistency, PHPUnit Filesystem Assertions has various style checks and unit tests bundled with it. These are defined in `composer` scripts. The included commands are:

- `style:check` &mdash; Check that PHP files follow coding standards
- `style:fix` &mdash; Automatically fix any coding standard errors
- `test:static` &mdash; Run static analysis on code
- `test:unit` &mdash; Run PHPUnit tests on code
- `test:coverage` &mdash; Run PHPUnit tests and generate a coverage report
- `test` &mdash; Run `style:check`, `test:static`, and `test:unit` in sequence

PHPUnit Filesystem Assertions uses [CaptainHook](http://captainhook.info/) to manage git hooks during development. Whenever you create a commit, CaptainHook will automatically lint your code and run through `composer test` for you. *Do not skip or disable the git hooks unless you have a very good reason for doing so!*

Finally, there are two additional tools meant to keep dependencies well defined:

- `vendor/bin/composer-require-checker` &mdash; Check that all dependencies are explicitly defined in `composer.json`
- `composer normalize` &mdash; Make sure `composer.json` is in a consistent order and format

If you modify `composer.json` make sure to run `composer normalize` before pushing your code to GitHub. Both these tools will be run against every pull request before merging.

### Creating a Pull Request

The final step for whatever coding work you perform is, naturally, opening a pull request. The pull request template will guide you through the required steps and details to get your PR merged easily. Make sure to read the instructions, fill out the required sections, and mark the appropriate items on the checklist. Failure to do so could cause delays in getting your pull request reviewed and merged.

<!-- omit in toc -->
## Attribution
This guide is based in part on content from [**contributing-gen**](https://github.com/bttger/contributing-gen).
