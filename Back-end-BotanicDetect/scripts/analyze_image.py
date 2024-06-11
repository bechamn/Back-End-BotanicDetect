import sys
import json
import numpy as np
import tensorflow as tf
from PIL import Image

# Load the TensorFlow Lite model
interpreter = tf.lite.Interpreter(model_path="scripts/tf_lite_Optimize_DEFAULT_model.tflite")
interpreter.allocate_tensors()

# Get input and output tensors
input_details = interpreter.get_input_details()
output_details = interpreter.get_output_details()

# Define the model input size
input_shape = input_details[0]['shape'][1:3]

# Preprocess the input image
def preprocess_image(image_path):
    img = Image.open(image_path)
    img = img.resize(input_shape)  # Resize based on the model input size
    img = np.array(img) / 255.0  # Normalize the image
    img = img.astype('float32')  # Cast to float32
    img = np.expand_dims(img, axis=0)  # Add batch dimension
    return img

# Function to perform inference
def predict(image_path):
    # Preprocess the input image
    input_data = preprocess_image(image_path)

    # Set the input tensor
    interpreter.set_tensor(input_details[0]['index'], input_data)

    # Perform the inference
    interpreter.invoke()

    # Get the output tensor
    output_data = interpreter.get_tensor(output_details[0]['index'])

    # Process the output (example: assuming a classification task)
    class_id = np.argmax(output_data)
    confidence = float(output_data[0][class_id])

    # Return the result as a dictionary
    return {"class_id": class_id, "confidence": confidence}

if __name__ == '__main__':
    image_path = sys.argv[1]
    result = predict(image_path)
    print(json.dumps(result))
