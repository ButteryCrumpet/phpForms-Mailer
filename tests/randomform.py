import random

TAGS = ["input", "select", "textarea"]
INPUT_TYPES = ["checkbox", "text", "radio", "select", "textarea"]
VALIDATION = ["generic", "email", "kana", "phone", "url", "keyval", "zip"]
REQUIRED = ["data-required", ""]
ERR_TEMPLATE = '<div data-error="required" data-errfor="{}}">{} is required please enter</div>\n<div data-error="invalid" data-errfor="{}}">{} is invalid please enter</div>'

def randomText():
    template = '<input data-ppForm type="text" name="{}" {}}>'
    name = randomName()
    required = random.choice(REQUIRED)
    template.format(name, required)
    template += ERR_TEMPLATE
    return template

def randomRadio():
    template = '<input data-ppForm type="radio" name="{}" data-valid="keyval" value="{}}">'
    name = randomName()
    val1 = randomName()
    val2 = randomName()
    template += template
    template.format(name, val1, name, val2)
    return template
    

def randomName():
    name = ""
    chars = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"]
    length = random.randrange(3,10);
    for i in range(length):
        name+=random.choice(chars)

    return name




