# testing only: gives the legend without forging it (does not count as crafted)
loot give @s loot mythic:legend/abyssdreizack
tellraw @s ["",{"text":"[Test] ","color":"dark_gray"},{"text": "Abyss-Dreizack", "color": "#8a6aff", "bold": true},{"text":" erhalten (zählt nicht als geschmiedet).","color":"gray"}]
