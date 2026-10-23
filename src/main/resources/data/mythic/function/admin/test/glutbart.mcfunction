# testing only: gives the legend without forging it (does not count as crafted)
loot give @s loot mythic:legend/glutbart
tellraw @s ["",{"text":"[Test] ","color":"dark_gray"},{"text": "Glutbart", "color": "#ff8a00", "bold": true},{"text":" erhalten (zählt nicht als geschmiedet).","color":"gray"}]
