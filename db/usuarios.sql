--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `contraseña` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO usuarios (`id`, `usuario`, `contraseña`) VALUES
(1, 'admin', '$2y$10$9d3C99OFVpyNbVsAtw1D/u.BNG0Q9j.7l9ckhVfVWc/yqu5ydsEGG'),   -- admin123
(2, 'user1', '$2y$10$2WclP9xSf7EQnP9gAAlo6uPv88sTEX3GMMGMWgqYki1C6IL.0/djO'),   -- user1
(3, 'user2', '$2y$10$qG62LoUx5ADRt1aSLi9R1esHKbzob1RiBJvwYrLEYUQ6AsDYwnNJu');   -- user2
