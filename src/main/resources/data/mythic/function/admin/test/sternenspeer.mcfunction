# testing only: gives the legend without forging it (does not count as crafted)
loot give @s loot mythic:legend/sternenspeer
tellraw @s ["",{"text":"[Test] ","color":"dark_gray"},{"text": "Sternenspeer", "color": "#c89aff", "bold": true},{"text":" erhalten (zählt nicht als geschmiedet).","color":"gray"}]
