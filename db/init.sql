CREATE TABLE consultas (
    id SERIAL PRIMARY KEY,
    ciudad VARCHAR(100),
    tipo VARCHAR(10) CHECK (tipo IN ('simple', 'complejo')),
    lat DECIMAL(9,6),
    lon DECIMAL(9,6),
    temp DECIMAL(5,2),
    descripcion VARCHAR(100),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);