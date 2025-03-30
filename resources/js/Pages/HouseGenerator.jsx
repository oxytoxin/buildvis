import React, { useMemo, useState } from "react";
import { Canvas } from "@react-three/fiber";
import { OrbitControls, Sky } from "@react-three/drei";
import * as THREE from "three";

const WALL_HEIGHT = 1;
const WALL_THICKNESS = 0.2;
const DOOR_WIDTH = 1;
const DOOR_HEIGHT = 1.5;
const DOOR_MARGIN = 0.2;
const ROOF_OFFSET = 0.2;


const Wall = ({ hasDoor = false, position, rotation, doorX, width, color = 'white' }) => {
    const wallShape = new THREE.Shape();
    wallShape.moveTo(-width, -WALL_HEIGHT);
    wallShape.lineTo(width, -WALL_HEIGHT);
    wallShape.lineTo(width, WALL_HEIGHT);
    wallShape.lineTo(-width, WALL_HEIGHT);
    wallShape.lineTo(-width, -WALL_HEIGHT);

    if (hasDoor) {
        const doorHole = new THREE.Path();
        doorHole.moveTo(doorX - DOOR_WIDTH / 2, -WALL_HEIGHT);
        doorHole.lineTo(doorX + DOOR_WIDTH / 2, -WALL_HEIGHT);
        doorHole.lineTo(doorX + DOOR_WIDTH / 2, -WALL_HEIGHT + DOOR_HEIGHT);
        doorHole.lineTo(doorX - DOOR_WIDTH / 2, -WALL_HEIGHT + DOOR_HEIGHT);
        doorHole.lineTo(doorX - DOOR_WIDTH / 2, -WALL_HEIGHT);
        wallShape.holes.push(doorHole);
    }

    const extrudeSettings = { depth: WALL_THICKNESS, bevelEnabled: false };

    return (
        <mesh position={position} rotation={rotation}>
            <extrudeGeometry args={[wallShape, extrudeSettings]} />
            <meshStandardMaterial color={color} />
        </mesh>
    );
};

// 🏠 Custom Roof with Rectangular Base
const Roof = ({ width, length, height, rotation }) => {
    const BASE_OFFSET = 0.5; // Controls how much the peak is inset

    const geometry = useMemo(() => {
        const vertices = new Float32Array([
            // Base rectangle (extended for overhang)
            -width / 2 - ROOF_OFFSET, 0, -length / 2 - ROOF_OFFSET, // 0
            width / 2 + ROOF_OFFSET, 0, -length / 2 - ROOF_OFFSET,  // 1
            width / 2 + ROOF_OFFSET, 0, length / 2 + ROOF_OFFSET,   // 2
            -width / 2 - ROOF_OFFSET, 0, length / 2 + ROOF_OFFSET,  // 3

            // **Inset Roof Peaks (to avoid touching the corners)**
            -width / 2 + BASE_OFFSET, height, 0,  // 4 (Left Peak)
            width / 2 - BASE_OFFSET, height, 0,   // 5 (Right Peak)
        ]);

        const indices = new Uint16Array([
            // Side faces
            0, 1, 4,
            1, 2, 5,
            2, 3, 5,
            3, 0, 4,

            // Triangular Top Connection
            4, 5, 1,
            4, 5, 3,

            // Base (rectangle)
            0, 1, 2,
            2, 3, 0,
        ]);

        const bufferGeometry = new THREE.BufferGeometry();
        bufferGeometry.setAttribute("position", new THREE.BufferAttribute(vertices, 3));
        bufferGeometry.setIndex(new THREE.BufferAttribute(indices, 1));

        return bufferGeometry;
    }, [width, length, height]); // Rebuild when size updates

    return (
        <mesh rotation={rotation} position={[0, WALL_HEIGHT, 0]} geometry={geometry}>
            <meshStandardMaterial side={THREE.DoubleSide} color="brown" />
        </mesh>
    );
};


const HollowHouse = ({ roofHeight, renderGrass, doorX, roomWidth, roomLength }) => {
    return (
        <group rotation={[0, Math.PI * 5 / 4, 0]}>
            {renderGrass && (
                <mesh position={[0, -0.01 - WALL_HEIGHT, 0]} rotation={[-Math.PI / 2, 0, 0]}>
                    <planeGeometry args={[1000, 1000]} />
                    <meshStandardMaterial color="green" />
                </mesh>
            )}
            <group>
                <Wall hasDoor={true} position={[0, 0, -roomLength]} doorX={doorX} width={roomWidth} />
                <Wall position={[0, 0, roomLength - WALL_THICKNESS]} width={roomWidth} />
                <Wall position={[roomWidth - WALL_THICKNESS, 0, 0]} rotation={[0, Math.PI / 2, 0]} width={roomLength} />
                <Wall position={[-roomWidth, 0, 0]} rotation={[0, Math.PI / 2, 0]} width={roomLength} />
                <Wall position={[0, 0, roomLength / 2]} rotation={[0, Math.PI / 2, 0]} width={roomLength / 2} />
                <Wall hasDoor={true} doorX={0} position={[roomWidth / 2, 0, 0]} rotation={[0, 0, 0]} width={roomWidth / 2} />
            </group>
            <Roof
                width={roomWidth * 2}
                length={roomLength * 2}
                height={roofHeight}
            />
            <ambientLight intensity={0.5} />
            <directionalLight position={[5, 5, 5]} intensity={1} />
        </group>
    );
};

const HouseScene = () => {
    const [roofHeight, setRoofHeight] = useState(1);
    const [renderGrass, setRenderGrass] = useState(false);
    const [doorX, setDoorX] = useState(0);
    const [roomWidth, setRoomWidth] = useState(Math.random() * 4 + 1);
    const [roomLength, setRoomLength] = useState(Math.random() * 4 + 1);

    const minDoorX = -roomWidth + DOOR_WIDTH / 2 + DOOR_MARGIN;
    const maxDoorX = roomWidth - DOOR_WIDTH / 2 - DOOR_MARGIN;

    return (
        <div className="h-screen w-full relative">
            <Canvas camera={{ position: [6, 4, 6] }} fog={{ color: "green", near: 10, far: 50 }}>
                <OrbitControls />
                <Sky sunPosition={[100, 20, 100]} />
                <HollowHouse
                    roofHeight={roofHeight}
                    renderGrass={renderGrass}
                    doorX={doorX}
                    roomWidth={roomWidth}
                    roomLength={roomLength}
                />
            </Canvas>

            <div className="absolute bottom-5 right-32 transform bg-white p-3 rounded shadow-lg">
                <label className="block text-sm font-bold">Roof Height: {roofHeight.toFixed(1)}</label>
                <input type="range" min="1" max="4" step="0.1" value={roofHeight} onChange={(e) => setRoofHeight(parseFloat(e.target.value))} className="w-40" />

                <div className="mt-3">
                    <label className="block text-sm font-bold">Door X Position: {doorX.toFixed(1)}</label>
                    <input type="range" min={minDoorX} max={maxDoorX} step="0.1" value={doorX} onChange={(e) => setDoorX(parseFloat(e.target.value))} className="w-40" />
                </div>

                <div className="mt-3">
                    <label className="block text-sm font-bold">Room Width: {roomWidth.toFixed(1)}</label>
                    <input type="range" min="2" max="6" step="0.1" value={roomWidth} onChange={(e) => setRoomWidth(parseFloat(e.target.value))} className="w-40" />
                </div>

                <div className="mt-3">
                    <label className="block text-sm font-bold">Room Length: {roomLength.toFixed(1)}</label>
                    <input type="range" min="2" max="6" step="0.1" value={roomLength} onChange={(e) => setRoomLength(parseFloat(e.target.value))} className="w-40" />
                </div>

                <div className="mt-3">
                    <label className="block text-sm font-bold">Render Grass</label>
                    <input type="checkbox" checked={renderGrass} onChange={() => setRenderGrass(!renderGrass)} className="ml-2" />
                </div>
            </div>
        </div>
    );
};

export default HouseScene;
