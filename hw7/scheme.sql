/* Таблица кинотеатров с множеством залов */
DROP TABLE IF EXISTS multiplexes;
CREATE TABLE multiplexes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    address VARCHAR(250) NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT true
);

/* Таблица залов в кинотеатрах */
DROP TABLE IF EXISTS theaters;
CREATE TABLE theaters (
    id SERIAL PRIMARY KEY,
    multiplex_id INTEGER NOT NULL REFERENCES multiplexes(id) ON DELETE CASCADE,
    name VARCHAR(120) NOT NULL, -- Название зала
    row_count INTEGER NOT NULL, -- Количество рядов в зале
    seats_per_row INTEGER NOT NULL, -- Количество мест в одном ряде
    is_active BOOLEAN NOT NULL DEFAULT true,

    -- Уникальное имя зала внутри одного театра
    CONSTRAINT unique_theater_name UNIQUE (multiplex_id, name)
);

/* Таблица мест в залах */
DROP TABLE IF EXISTS seats;
CREATE TABLE seats (
    id SERIAL PRIMARY KEY,
    theater_id INTEGER NOT NULL REFERENCES theaters(id) ON DELETE CASCADE,
    row_number INTEGER NOT NULL,
    seat_number INTEGER NOT NULL,

    -- В одном зале не может быть двух одинаковых мест
    CONSTRAINT unique_seat UNIQUE (theater_id, row_number, seat_number)
);

/* Таблица фильмов */
DROP TABLE IF EXISTS movies;
CREATE TABLE movies (
    id SERIAL PRIMARY KEY,
    title VARCHAR(250) NOT NULL,
    description TEXT,
    restrictions VARCHAR(60) NOT NULL DEFAULT '', -- Всякие ограничения, например, 16+ 
    duration INTEGER NOT NULL, -- Длительность в минутах
    release_date DATE
);

/* Таблица сеансов */
DROP TABLE IF EXISTS watchings;
CREATE TABLE watchings (
    id SERIAL PRIMARY KEY,
    movie_id INTEGER NOT NULL REFERENCES movies(id) ON DELETE CASCADE,
    theater_id INTEGER NOT NULL REFERENCES theaters(id) ON DELETE CASCADE,
    start_time TIMESTAMP WITH TIME ZONE NOT NULL,

    -- Один зал не может быть занят двумя сеансами одновременно.
    CONSTRAINT unique_theater_time UNIQUE (theater_id, start_time)
);

/* Таблица билетов */
DROP TABLE IF EXISTS tickets;
DROP TYPE IF EXISTS ticket_status;
CREATE TYPE ticket_status AS ENUM ('available', 'booked', 'paid');
CREATE TABLE tickets (
    id SERIAL PRIMARY KEY,
    watching_id INTEGER NOT NULL REFERENCES watchings(id) ON DELETE RESTRICT,
    seat_id INTEGER NOT NULL REFERENCES seats(id) ON DELETE RESTRICT,
    price NUMERIC(10, 2) NOT NULL,
    booked_at TIMESTAMP WITH TIME ZONE DEFAULT NULL,
    status ticket_status NOT NULL DEFAULT 'available',
    is_active BOOLEAN NOT NULL DEFAULT true, -- Продается / Учитывается в статистике
    
    -- На один сеанс в одно место нельзя продать два билета
    CONSTRAINT unique_watching_seat UNIQUE (watching_id, seat_id)
);
