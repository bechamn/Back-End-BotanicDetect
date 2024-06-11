import sys
import json
import numpy as np
import tensorflow as tf
from PIL import Image

# Load the TensorFlow Lite model
interpreter = tf.lite.Interpreter(model_path="scripts/tf_lite_Optimize_DEFAULT_model.tflite")
interpreter.allocate_tensors()

# Preprocess the input image
def load_and_preprocess_image(image_path, target_size=(300, 300)):
    img = Image.open(image_path)
    img = img.resize(target_size)
    img_array = np.array(img, dtype=np.float32) / 255.0
    img_array = np.expand_dims(img_array, axis=0)
    return img_array

# Function to perform inference
def classify_image_tflite(interpreter, image_path, class_labels):
    input_details = interpreter.get_input_details()
    output_details = interpreter.get_output_details()

    img_array = load_and_preprocess_image(image_path, target_size=(input_details[0]['shape'][1], input_details[0]['shape'][2]))

    interpreter.set_tensor(input_details[0]['index'], img_array)
    interpreter.invoke()

    predictions = interpreter.get_tensor(output_details[0]['index'])
    predicted_class_index = np.argmax(predictions)
    predicted_class = class_labels[predicted_class_index]
    confidence = predictions[0][predicted_class_index]

    return predicted_class, confidence

if __name__ == '__main__':
    class_labels = [
        'Apple Apple scab',
        'Apple Black rot',
        'Apple Cedar apple rust',
        'Apple healthy',
        'Bacterial leaf blight in rice leaf',
        'Blight in corn Leaf',
        'Blueberry healthy',
        'Brown spot in rice leaf',
        'Cercospora leaf spot',
        'Cherry (including sour) Powdery mildew',
        'Cherry (including_sour) healthy',
        'Common Rust in corn Leaf',
        'Corn (maize) healthy',
        'Garlic',
        'Grape Black rot',
        'Grape Esca Black Measles',
        'Grape Leaf blight Isariopsis Leaf Spot',
        'Grape healthy',
        'Gray Leaf Spot in corn Leaf',
        'Leaf smut in rice leaf',
        'Orange Haunglongbing Citrus greening',
        'Peach healthy',
        'Pepper bell Bacterial spot',
        'Pepper bell healthy',
        'Potato Early blight',
        'Potato Late blight',
        'Potato healthy',
        'Raspberry healthy',
        'Sogatella rice',
        'Soybean healthy',
        'Strawberry Leaf scorch',
        'Strawberry healthy',
        'Tomato Bacterial spot',
        'Tomato Early blight',
        'Tomato Late blight',
        'Tomato Leaf Mold',
        'Tomato Septoria leaf spot',
        'Tomato Spider mites Two spotted spider mite',
        'Tomato Target Spot',
        'Tomato Tomato mosaic virus',
        'Tomato healthy',
        'algal leaf in tea',
        'anthracnose in tea',
        'bird eye spot in tea',
        'brown blight in tea',
        'cabbage looper',
        'corn crop',
        'ginger',
        'healthy tea leaf',
        'lemon canker',
        'onion',
        'potassium deficiency in plant',
        'potato crop',
        'potato hollow heart',
        'red leaf spot in tea',
        'tomato canker'
    ]
    image_path = sys.argv[1]
    predicted_class, confidence = classify_image_tflite(interpreter, image_path, class_labels)
    print(json.dumps(predicted_class))
