UPDATE wp_options SET option_value = replace(option_value, 'http://sfaera.innate-media.net', 'http://localhost/sfaera');
UPDATE wp_posts SET guid = replace(guid, 'http://sfaera.innate-media.net', 'http://localhost/sfaera');
UPDATE wp_posts SET post_content = replace(post_content, 'http://sfaera.innate-media.net', 'http://localhost/sfaera');
UPDATE wp_posts SET guid = replace(guid, 'http://localhost/sggit/sfaera', 'http://localhost/sfaera');

