USE reservation_platform;

INSERT INTO services
(business_id, employee_user_id, name, category, description, duration_minutes, price, is_active)
SELECT
    b.id,
    u.id,
    s.name,
    s.category,
    s.description,
    s.duration_minutes,
    s.price,
    1
FROM businesses b
         JOIN (
    SELECT 'emp1@demo.com'  AS emp_email, 'Haircut & Styling' AS name, 'Hair' AS category,
           'Professional haircut and styling tailored to your face shape and preferences.' AS description, 45 AS duration_minutes, 15.00 AS price

    UNION ALL SELECT 'emp2@demo.com',  'Haircut', 'Hair',
                     'Classic or modern haircut customized to your style.', 30, 12.00

    UNION ALL SELECT 'emp3@demo.com',  'Wash & Blow-Dry', 'Styling',
                     'Hair wash with professional products followed by a smooth or voluminous blow-dry.', 30, 8.00

    UNION ALL SELECT 'emp4@demo.com',  'Full Hair Coloring', 'Color',
                     'Complete hair coloring using high-quality professional dyes.', 90, 30.00

    UNION ALL SELECT 'emp5@demo.com',  'Root Touch Up', 'Color',
                     'Color refresh for roots to maintain an even tone.', 60, 20.00

    UNION ALL SELECT 'emp6@demo.com',  'Balayage', 'Color',
                     'Natural-looking highlights for a modern, sun-kissed effect.', 120, 80.00

    UNION ALL SELECT 'emp7@demo.com',  'Highlights', 'Color',
                     'Classic or modern highlights for added dimension and brightness.', 100, 60.00

    UNION ALL SELECT 'emp8@demo.com',  'Hair Mask & Treatment', 'Treatment',
                     'Deep conditioning treatment to restore and nourish damaged hair.', 30, 15.00

    UNION ALL SELECT 'emp9@demo.com',  'Keratin Treatment', 'Treatment',
                     'Smoothing treatment that reduces frizz and adds shine.', 120, 70.00

    UNION ALL SELECT 'emp10@demo.com', 'Botox Hair Treatment', 'Treatment',
                     'Intensive repair treatment for dry and damaged hair.', 90, 50.00

    UNION ALL SELECT 'emp11@demo.com', 'Blow-Dry Styling', 'Styling',
                     'Professional blow-dry for a polished everyday look.', 30, 10.00

    UNION ALL SELECT 'emp12@demo.com', 'Curling / Waves', 'Styling',
                     'Soft curls or beach waves for a stylish finish.', 30, 12.00

    UNION ALL SELECT 'emp13@demo.com', 'Hair Straightening', 'Styling',
                     'Sleek and smooth straightening using professional tools.', 30, 12.00

    UNION ALL SELECT 'emp14@demo.com', 'Bridal Hairstyle', 'Styling',
                     'Elegant and long-lasting hairstyle for your special day.', 90, 60.00

    UNION ALL SELECT 'emp15@demo.com', 'Event / Evening Hairstyle', 'Styling',
                     'Glamorous hairstyle for parties and special occasions.', 60, 30.00

    UNION ALL SELECT 'emp16@demo.com', 'Hair Consultation', 'Consultation',
                     'Personalized consultation to choose the best style or treatment.', 15, 0.00

    UNION ALL SELECT 'emp17@demo.com', 'Hair Extensions Consultation', 'Consultation',
                     'Consultation for hair extensions, color matching and method selection.', 20, 0.00
) s
         JOIN users u ON u.email = s.emp_email
WHERE b.name = 'Salon Demo';
