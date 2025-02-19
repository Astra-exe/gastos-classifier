# Usar una imagen base de Python
FROM python:3.12.9-slim

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copiar el archivo de dependencias
COPY requirements.txt .

# Instalar dependencias del sistema (necesarias para algunas bibliotecas como scipy y pandas)
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    gcc \
    default-libmysqlclient-dev \
    pkg-config \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar las dependencias de Python
RUN pip install --no-cache-dir -r requirements.txt

# Copiar el resto del código de la aplicación
COPY . /app/

# Exponer el puerto en el que corre la API
EXPOSE 5000

# Comando para ejecutar la API
CMD ["flask", "run", "--host", "0.0.0.0", "--port", "5000", "--debug"]
