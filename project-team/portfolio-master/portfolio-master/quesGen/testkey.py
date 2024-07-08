import openai
import os

def is_api_key_valid(api_key):
    # Set the OpenAI API key
    openai.api_key = api_key
    
    try:
        # Make a simple API call to check the validity of the key
        openai.Engine.list()
        return True
    except openai.error.AuthenticationError:
        return False
    except Exception as e:
        print(f"An error occurred: {e}")
        return False

if __name__ == "__main__":
    # Replace 'your-api-key' with your actual OpenAI API key or use an environment variable
    api_key = os.getenv("OPENAI_API_KEY", "sk-proj-TPxOJiroatUEClga6LsQT3BlbkFJH7obo2Oxl0MlCtVrsofL")
    
    if is_api_key_valid(api_key):
        print("The API key is valid.")
    else:
        print("The API key is invalid or an error occurred.")
