# a sealed Abyss-Dreizack reached a player's inventory
clear @s *[minecraft:custom_data~{mythic_seal:"abyssdreizack"}] 1
execute if score #abyssdreizack mythic.forged matches 1.. run return run function mythic:legend/abyssdreizack/denied
scoreboard players set #abyssdreizack mythic.forged 1
loot give @s loot mythic:legend/abyssdreizack
recipe take @a mythic:abyssdreizack
tellraw @a ["",{"text":"✦ ","color":"gold"},{"selector":"@s","color":"white"},{"text":" hat die Legende ","color":"gray"},{"text": "Abyss-Dreizack", "color": "#8a6aff", "bold": true},{"text":" geschmiedet! Es gibt sie nur dieses eine Mal.","color":"gray"}]
execute as @a at @s run playsound minecraft:ui.toast.challenge_complete master @s ~ ~ ~ 1 1
execute at @s run particle minecraft:totem_of_undying ~ ~1 ~ 0.5 0.8 0.5 0.4 60
