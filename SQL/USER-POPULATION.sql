USE lgn_db;

INSERT INTO users (email, pass, is_locked)
VALUES
  ('josh@example.com',  TO_BASE64('password1'),  0),
  ('rhi@example.com',   TO_BASE64('password2'),  0),
  ('leo@example.com',   TO_BASE64('password3'),  1),
  ('oli@example.com',   TO_BASE64('password4'),  0),
  ('cayde@example.com', TO_BASE64('password5'),  1),
  ('schro@example.com', TO_BASE64('password6'),  0),
  ('veil@example.com',  TO_BASE64('password7'),  1),
  ('night@example.com', TO_BASE64('password8'),  0),
  ('safe@example.com',  TO_BASE64('password9'),  1),
  ('hks@example.com',   TO_BASE64('password10'), 0);