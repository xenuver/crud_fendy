import re

with open('app/Database/Seeds/MainSeeder.php', 'r') as f:
    content = f.read()

start_marker = "if ($this->db->table('settings')->countAllResults() == 0) {"
end_marker = "$this->db->table('settings')->insertBatch($data);"

start_idx = content.find(start_marker)
end_idx = content.find(end_marker) + len(end_marker)

settings_block = content[start_idx:end_idx]
new_settings_block = settings_block.replace("'id' => ", "'setting_id' => ")
content = content[:start_idx] + new_settings_block + content[end_idx:]

with open('app/Database/Seeds/MainSeeder.php', 'w') as f:
    f.write(content)
print('Done!')
