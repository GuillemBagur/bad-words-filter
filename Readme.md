# BadWordsFilter

A tiny library to automatically reject rude texts.

## Installation

To use BadWordsFilter, you only have to download the files and include them in a folder of your project. You can also run `git clone` inside a folder in your project to have it via Git.

## Capabilities

This tiny library is useful to make a fast verification to see if a text is polite or rude. It's not magic, it only has a bunch of words and checks them (and their variations, v4riations, v4ria7ions, varia7ion5, ...). It supports Spanish verbs as well. Due to language nature, this library works well in English and Spanish. Not specially designed for German, French, etc. However, you can take advantatge of some of its power on any latin-alphabet based language.

## Usage

### Basic
This library is *plug & play*, so after installing it, you only need to include the class file `BadWordsFilter.php` and use it's method `check`, which returns a boolean based on argument-given string (`true` if polite, `false` if rude).

### Adding more words to dictionary

Dictionary is called `bad_words.php`. If you'd like to customize it, you'd have to follow the same structure:
- `nouns`: any word that is a noun. All languages together (some order is recommended).
- `verbs`: add any verbs you'd like. Due how the library treats verbs (less strict than nouns), I'd recommend you to keep this list short. The more words you add, the odds of rejecting a polite sentence grow a little bit. **This list only works with Spanish verbs!**

**Important** All the words you add in the dictionary must be ASCII only. No accents allowed.

> **Note**: having duplicated entries is not a problem, but it could affect performance.

## Credits

- Inspired by [https://github.com/mioga-technik/badwords](https://github.com/mioga-technik/badwords)
- Developed by [https://guiem.dev](Guiem Bagur)