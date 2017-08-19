import random

TAGS = ["input", "select", "textarea"]
INPUT_TYPES = ["checkbox", "text", "radio", "select", "textarea"]
VALIDATION = ["generic", "email", "kana", "phone", "url", "keyval", "zip"]
REQUIRED = ["data-required", ""]
ERR_TEMPLATE = '\n<div data-error="required" data-errfor="{0}">{0} is required please enter</div>\n<div data-error="invalid" data-errfor="{0}">{0} is invalid please enter</div>\n'

def randomTextInput():
    name = randomName()
    valid = random.choice(VALIDATION)
    template = '<input data-ppForm type="text" name="{}" data-required data-valid="{}">'.format(name, valid)
    template += ERR_TEMPLATE.format(name)
    return template

def randomTextAreaInput():
    name = randomName()
    valid = random.choice(VALIDATION)
    template = '<textarea data-ppForm type="text" name="{}" data-required data-valid="{}"></textarea>'.format(name, valid)
    template += ERR_TEMPLATE.format(name)
    return template


def randomName():
    name = ""
    chars = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"]
    length = random.randrange(3,10);
    for i in range(length):
        name+=random.choice(chars)

    return name
