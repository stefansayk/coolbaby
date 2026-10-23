# testing only: gives the legend without forging it (does not count as crafted)
loot give @s loot mythic:legend/tiefseejaeger
tellraw @s ["",{"text":"[Test] ","color":"dark_gray"},{"text": "Tiefseejäger", "color": "#3a8cff", "bold": true},{"text":" erhalten (zählt nicht als geschmiedet).","color":"gray"}]
