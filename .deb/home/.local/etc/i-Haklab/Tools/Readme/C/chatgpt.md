# Quick guide for option chatGPT from command i-Haklab.

A simple, lightweight shell script to use OpenAI's chatGPT and DALL-E from the terminal.
The script uses the `completions` endpoint and the `text-davinci-003` model for chatGPT and the `images/generations` endpoint for generating images.
/
## Features

- Chat with GPT from the terminal
- Generate images from a text prompt
- View your chat history
- Chat context, GPT remembers previous chat questions and answers
- List all available OpenAI models 
- Set OpenAI request parameters

## Getting Started

## Usage

### Start

  - Run the script by using the `chatGPT` option from the command i-Haklab anywhere
  ```bash
  i-Haklab chatGPT
  ```

### Commands

  - `image:` To generate images, start a prompt with `image:`
    If you are using iTerm, you can view the image directly in the terminal. Otherwise the script will ask to open the image in your browser.
  - `history` To view your chat history, type `history`
  - `models` To get a list of the models available at OpenAI API, type `models`
  - `model:` To view all the information on a specific model, start a prompt with `model:` and the model `id` as it appears in the list of models. For example: `model:text-babbage:001` will get you all the fields for `text-babbage:001` model

### Chat context

  - You can enable chat context mode for the model to remember your previous chat questions and answers. This way you can ask follow-up questions. To enable this mode start the script with `-c` or `--chat-context`. i.e. `i-Haklab chatGPT --chat-context` and start to chat normally.

### Set request parameters

  - To set request parameters you can start the script like this: `i-Haklab chatGPT --temperature 0.9 --model text-babbage:001 --max-tokens 100 --size 1024x1024`
  
    The available parameters are: 
      - temperature,  `-t` or `--temperature`
      - model, `-m` or `--model`
      - max number of tokens, `--max-tokens`
      - image size, `-s` or `--size` (The sizes that are accepted by the OpenAI API are 256x256, 512x512, 1024x1024)
      
    To learn more about these parameters you can view the [API documentation](https://platform.openai.com/docs/api-reference/completions/create)

