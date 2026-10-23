# Erdbeben: Bodenschlag: 6 Schaden im Umkreis von 5 Blöcken, Gegner fliegen hoch und werden langsam.
tag @e[type=!#mythic:not_target,tag=!mythic.caster,distance=..5] add mythic.t
execute as @e[tag=mythic.t] run damage @s 6 minecraft:player_attack by @p[tag=mythic.caster]
effect give @e[tag=mythic.t] minecraft:levitation 1 1 true
effect give @e[tag=mythic.t] minecraft:slowness 3 2
particle minecraft:explosion ~ ~ ~ 2 0.2 2 0 8
particle minecraft:lava ~ ~0.3 ~ 2.5 0.2 2.5 0 25
particle minecraft:campfire_cosy_smoke ~ ~0.2 ~ 2 0.1 2 0.02 20
playsound minecraft:item.mace.smash_ground_heavy player @a ~ ~ ~ 1 0.8
playsound minecraft:entity.generic.explode player @a ~ ~ ~ 0.6 1.2
tag @e[tag=mythic.t] remove mythic.t
