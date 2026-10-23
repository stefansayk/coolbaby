# Schattenschritt: Teleportiert dich bis zu 8 Blöcke nach vorn und gibt dir 4 s Stärke.
particle minecraft:soul_fire_flame ~ ~1 ~ 0.3 0.6 0.3 0.05 30
scoreboard players set @s mythic.steps 0
execute rotated ~ 0 run function mythic:util/blink
effect give @s minecraft:strength 4 0
execute at @s run particle minecraft:soul ~ ~1 ~ 0.4 0.6 0.4 0.05 40
execute at @s run playsound minecraft:entity.enderman.teleport player @a ~ ~ ~ 1 0.6
