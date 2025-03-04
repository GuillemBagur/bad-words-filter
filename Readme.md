# BadWordsFilter

A tiny library to automatically reject rude texts.

## Installation

To use BadWordsFilter, you only have to download the files and include them in a folder of your project. You can also run `git clone` inside a folder in your project to have it via Git.

## Capabilities

This tiny library is useful to make a fast verification to see if a text is polite or rude. It's not magic, it only has a bunch of words and checks them (and their variations, v4riations, v4ria7ions, varia7ion5, ...). It supports Spanish verbs as well. Due to language nature, this library works well in English and Spanish. Not specially designed for German, French, etc. However, you can take advantatge of some of its power on any latin-alphabet based language.

After that, it also checks for links and 

## Usage

### Basic

This library is *plug & play*, so after installing it, you only need to include the class file `BadWordsFilter.php` and use it's method `check`, which returns a boolean based on argument-given string (`true` if polite, `false` if rude). With the default configuration, it'll classify as *rude* any text with a URL or HTML tags. You can cange that setting some params to `true`.

The 4 params are
1. Allow bad words (nouns)
2. Allow bad words (verbs)
3. Allow urls
4. Allow HTML tags

### Examples

`$bad_words_filter = new BadWordsFilter();` is the same as `$bad_words_filter = new BadWordsFilter(false, false, false, false);`.
`$bad_words_filter = new BadWordsFilter(true, true, false, false);` Would only mark as *rude* all the bad words, but URLs and HTML tags would be allowed.



### Adding more words to dictionary

Dictionary is called `bad_words.php`. If you'd like to customize it, you'd have to follow the same structure:
- `nouns`: any word that is a noun. All languages together (some order is recommended). The class will automatically generate all possible variations of that noun.
- `verbs`: add any verbs you'd like. Due how the library treats verbs (less strict than nouns), I'd recommend you to keep this list short. The more words you add, the odds of rejecting a polite sentence grow a little bit. You must add verbs here in infinitive form, the class handles the rest. **This list only works with Spanish verbs!**

**Important** All the words you add in the dictionary must be ASCII only. No accents allowed.

> **Note**: having duplicated entries is not a problem, but it could affect performance.

## How it works

### Finding bad words (nouns)

It iterates through the bad words nouns dictionary and generates a regex containing all the possible variations of that bad word. Then, it searches for matches (whole word) in the text. If a match is found, it stops the research. If not, it gets the next word of the dictionary and continues. 

### Finding bad words (verbs)

Similar to finding nouns, but that's less strict. The library suppouses that all the verbs in the dictonary end by 'r'. The class removes that 'r' and searches for matches (words starting with the verb, less the 'r'). I think that's a good approach to get all conjugations of a verb in Spanish.

### Finding URLs

It applies the following regex: `/((https?:\/\/|www\.)[a-zA-Z0-9-]+(\.[a-zA-Z]{2,})(:[0-9]{1,5})?(\/\S*)?)/i`. It supports ports and paths.

### Finding HTML tags

It applies this simple but working regex: `/<[^>]+>/i`


## Credits

- Inspired by [https://github.com/mioga-technik/badwords](https://github.com/mioga-technik/badwords)
- Developed by [Guiem Bagur](https://guiem.dev)

## License

- This library is only 100 lines of code. Do whatever you want with it.