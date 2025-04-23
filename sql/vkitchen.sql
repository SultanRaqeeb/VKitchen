
CREATE TABLE users (
    uid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
);


CREATE TABLE recipes (
    rid INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    type ENUM('French', 'Italian', 'Chinese', 'Indian', 'Mexican', 'others') NOT NULL,
    cookingtime INT NOT NULL,
    ingredients TEXT NOT NULL,
    instructions TEXT NOT NULL,
    image VARCHAR(255),
    uid INT,
    FOREIGN KEY (uid) REFERENCES users(uid)
);

INSERT INTO users (username, password, email)
VALUES ('demouser', '$2y$10$wH6gA6FqAb/iwqABsWR9euK0VMIaBhRHJPqgyFlRKiBQY96yPGViG', 'demo@gmail.com');
-- Password is: demo123


INSERT INTO recipes (name, description, type, cookingtime, ingredients, instructions, image, uid)
VALUES
-- Spaghetti Bolognese
('Spaghetti Bolognese', 'A classic Italian pasta dish.', 'Italian', 45,
 'Pasta, minced meat, tomato sauce, onion, garlic',
 '1. Boil pasta until al dente.\n2. Sauté onions and garlic.\n3. Add minced meat and cook until browned.\n4. Pour in tomato sauce and simmer for 20 mins.\n5. Combine with pasta and serve.',
 'images/spaghetti.jpg', 1),

-- Chicken Tikka Masala
('Chicken Tikka Masala', 'Popular Indian curry dish.', 'Indian', 60,
 'Chicken, yogurt, spices, tomato puree, cream, onion, garlic, ginger',
 '1. Marinate chicken in yogurt and spices for at least 1 hour.\n2. Grill or sauté the chicken.\n3. Sauté onions, garlic, and ginger.\n4. Add tomato puree and simmer.\n5. Add grilled chicken and cream.\n6. Simmer for 15 mins and serve with rice or naan.',
 'images/tikka.jpg', 1),

-- Pad Thai
('Pad Thai', 'Popular Thai stir-fried noodle dish with sweet, salty, and tangy flavors.', 'Chinese', 30,
 'Rice noodles, shrimp or tofu, garlic, shallots, bean sprouts, eggs, peanuts, tamarind paste, fish sauce, lime, sugar, chili flakes, oil',
 '1. Soak rice noodles in warm water for 30 minutes until soft.\n2. Heat oil in a wok and sauté garlic and shallots.\n3. Add shrimp or tofu and cook until golden.\n4. Push ingredients to the side and scramble eggs in the center.\n5. Add noodles and toss everything together.\n6. Pour in sauce (tamarind, fish sauce, sugar) and stir to coat.\n7. Add bean sprouts and stir-fry briefly.\n8. Serve with crushed peanuts, lime wedges, and chili flakes on top.',
 'images/padthai.jpg', 1),

-- Beef Stroganoff
('Beef Stroganoff', 'Creamy Russian-style beef and mushroom dish.', 'French', 40,
 'Beef strips, mushrooms, onion, garlic, sour cream, butter, flour, beef stock, mustard',
 '1. Sauté onions and garlic in butter.\n2. Add mushrooms and cook until soft.\n3. Add beef strips and brown them.\n4. Sprinkle flour and mix.\n5. Pour in beef stock and bring to a simmer.\n6. Stir in sour cream and mustard.\n7. Simmer until thickened.\n8. Serve over pasta or rice.',
 'images/stroganoff.jpg', 1),

-- Tacos al Pastor
('Tacos al Pastor', 'Mexican street-style pork tacos with pineapple.', 'Mexican', 35,
 'Pork, pineapple, onion, chili, corn tortillas, garlic, vinegar, spices',
 '1. Marinate pork with chili, garlic, vinegar, and spices overnight.\n2. Grill or pan-fry pork with pineapple chunks.\n3. Warm corn tortillas.\n4. Fill tortillas with pork and pineapple.\n5. Top with diced onions and cilantro.\n6. Serve with lime wedges.',
 'images/tacos.jpg', 1),

-- Sushi Rolls
('Sushi Rolls', 'Traditional Japanese sushi with vegetables and seafood.', 'others', 50,
 'Sushi rice, nori sheets, raw fish or cooked seafood, cucumber, avocado, soy sauce, rice vinegar',
 '1. Rinse and cook sushi rice, then season with rice vinegar.\n2. Place nori sheet on bamboo mat.\n3. Spread rice over nori, leaving a 1-inch border.\n4. Add filling ingredients (fish, cucumber, avocado).\n5. Roll tightly using the mat.\n6. Slice with a wet sharp knife.\n7. Serve with soy sauce and wasabi.',
 'images/sushi.jpg', 1);
