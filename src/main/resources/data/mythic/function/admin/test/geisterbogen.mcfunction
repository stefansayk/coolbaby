# testing only: gives the legend without forging it (does not count as crafted)
loot give @s loot mythic:legend/geisterbogen
tellraw @s ["",{"text":"[Test] ","color":"dark_gray"},{"text": "Geisterbogen", "color": "#b8ff3a", "bold": true},{"text":" erhalten (zählt nicht als geschmiedet).","color":"gray"}]
