/* Самый прибыльный фильм (по сумме проданных билетов) */
SELECT
    m.id,
    m.title,
    SUM(t.price) AS total_sum,
    COUNT(t.id) AS tickets_sold
FROM movies m
JOIN watchings w ON w.movie_id = m.id
JOIN tickets  t ON t.watching_id = w.id
WHERE t.status = 'paid'
GROUP BY m.id, m.title
ORDER BY total_sum DESC
LIMIT 1;
