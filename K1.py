from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/')
def home():
    return "✅ API Aktif - Hoş geldin!"

@app.route('/paranet', methods=['GET'])
def paranet():
    data = {
        "durum": "başarılı",
        "veri": "Bu Paranet API'den gelen örnek veridir."
    }
    return jsonify(data)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=3000)
