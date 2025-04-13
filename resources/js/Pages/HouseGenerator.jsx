import React, { useMemo, useState, useEffect, useRef } from "react";
import { Canvas, useFrame, useThree } from "@react-three/fiber";
import { OrbitControls, Sky } from "@react-three/drei";
import * as THREE from "three";
import axios from "axios"; // Add axios for API requests

const WALL_HEIGHT = 1;
const WALL_THICKNESS = 0.2;
const DOOR_WIDTH = 0.85;
const DOOR_HEIGHT = 1.3;
const DOOR_MARGIN = 0.2;
const ROOF_OFFSET = 0.2;
// Default number of stories (now controlled by state)

// Window properties
const WINDOW_WIDTH = 0.5;  // Width of each pane (smaller for double-pane)
const WINDOW_HEIGHT = 0.5;  // Height of window
const WINDOW_MARGIN = 0.5;  // Margin between window sets
const WINDOW_PANE_GAP = 0.05; // Gap between the two panes of a window

// WASD Camera Controls Component
const WASDControls = ({ moveSpeed = 0.15, lookSpeed = 0.005 }) => {
    const { camera, gl } = useThree();
    const keys = useRef({ w: false, a: false, s: false, d: false, shift: false, space: false, c: false });
    const mousePos = useRef({ x: 0, y: 0 });

    // Store Euler angles to prevent tilting
    const euler = useRef(new THREE.Euler(0, 0, 0, 'YXZ'));

    // Initialize camera rotation
    useEffect(() => {
        // Set initial rotation
        euler.current.setFromQuaternion(camera.quaternion);

        // Ensure camera is using the correct up vector
        camera.up.set(0, 1, 0);
    }, [camera]);

    // Set up key listeners
    useEffect(() => {
        const handleKeyDown = (e) => {
            if (e.key.toLowerCase() === 'w') keys.current.w = true;
            if (e.key.toLowerCase() === 'a') keys.current.a = true;
            if (e.key.toLowerCase() === 's') keys.current.s = true;
            if (e.key.toLowerCase() === 'd') keys.current.d = true;
            if (e.key === 'Shift') keys.current.shift = true;
            if (e.key === ' ') keys.current.space = true;
            if (e.key.toLowerCase() === 'c') keys.current.c = true;
        };

        const handleKeyUp = (e) => {
            if (e.key.toLowerCase() === 'w') keys.current.w = false;
            if (e.key.toLowerCase() === 'a') keys.current.a = false;
            if (e.key.toLowerCase() === 's') keys.current.s = false;
            if (e.key.toLowerCase() === 'd') keys.current.d = false;
            if (e.key === 'Shift') keys.current.shift = false;
            if (e.key === ' ') keys.current.space = false;
            if (e.key.toLowerCase() === 'c') keys.current.c = false;
        };

        // Lock pointer when canvas is clicked
        const handleCanvasClick = () => {
            if (!document.pointerLockElement) {
                gl.domElement.requestPointerLock();
            }
        };

        // Handle mouse movement for camera rotation
        const handleMouseMove = (e) => {
            if (document.pointerLockElement === gl.domElement) {
                // Use movementX/Y for smooth camera rotation
                mousePos.current.x = e.movementX;
                mousePos.current.y = e.movementY;
            }
        };

        // Prevent context menu on right-click
        const handleContextMenu = (e) => {
            e.preventDefault();
        };

        window.addEventListener('keydown', handleKeyDown);
        window.addEventListener('keyup', handleKeyUp);
        gl.domElement.addEventListener('click', handleCanvasClick);
        window.addEventListener('mousemove', handleMouseMove);
        gl.domElement.addEventListener('contextmenu', handleContextMenu);

        return () => {
            window.removeEventListener('keydown', handleKeyDown);
            window.removeEventListener('keyup', handleKeyUp);
            gl.domElement.removeEventListener('click', handleCanvasClick);
            window.removeEventListener('mousemove', handleMouseMove);
            gl.domElement.removeEventListener('contextmenu', handleContextMenu);
            if (document.pointerLockElement === gl.domElement) {
                document.exitPointerLock();
            }
        };
    }, [gl]);

    // Update camera position and rotation on each frame
    useFrame(() => {
        // Movement speed (faster with shift)
        const currentSpeed = keys.current.shift ? moveSpeed * 2 : moveSpeed;

        // Get camera direction vectors
        const forward = new THREE.Vector3(0, 0, -1).applyQuaternion(camera.quaternion);
        const right = new THREE.Vector3(1, 0, 0).applyQuaternion(camera.quaternion);

        // Ensure movement is only on the horizontal plane (no vertical movement from looking up/down)
        forward.y = 0;
        forward.normalize();
        right.y = 0;
        right.normalize();

        // WASD movement
        if (keys.current.w) camera.position.addScaledVector(forward, currentSpeed);
        if (keys.current.s) camera.position.addScaledVector(forward, -currentSpeed);
        if (keys.current.a) camera.position.addScaledVector(right, -currentSpeed);
        if (keys.current.d) camera.position.addScaledVector(right, currentSpeed);

        // Vertical movement (Space to go up, C to go down)
        if (keys.current.space) camera.position.y += currentSpeed;
        if (keys.current.c) camera.position.y -= currentSpeed;

        // Mouse look (when pointer is locked)
        if (document.pointerLockElement === gl.domElement) {
            // Get current Euler angles
            euler.current.setFromQuaternion(camera.quaternion);

            // Determine the dominant direction of mouse movement
            const absX = Math.abs(mousePos.current.x);
            const absY = Math.abs(mousePos.current.y);

            if (absX > absY && absX > 1) {
                // Horizontal movement is dominant - only rotate horizontally
                euler.current.y -= mousePos.current.x * lookSpeed;
            } else if (absY > absX && absY > 1) {
                // Vertical movement is dominant - only rotate vertically
                // Limit vertical rotation to avoid flipping
                euler.current.x -= mousePos.current.y * lookSpeed;
                euler.current.x = Math.max(-Math.PI / 2, Math.min(Math.PI / 2, euler.current.x));
            }

            // Apply rotation while maintaining the up vector
            camera.quaternion.setFromEuler(euler.current);
            camera.up.set(0, 1, 0); // Ensure the up vector stays pointing up

            // Reset mouse movement
            mousePos.current.x = 0;
            mousePos.current.y = 0;
        }
    });

    return null; // This component doesn't render anything
};

const Wall = ({ hasDoor = false, position, rotation, doorX = 0, width, color = 'white', windows = [] }) => {
    const wallShape = new THREE.Shape();
    wallShape.moveTo(-width, -WALL_HEIGHT);
    wallShape.lineTo(width, -WALL_HEIGHT);
    wallShape.lineTo(width, WALL_HEIGHT);
    wallShape.lineTo(-width, WALL_HEIGHT);
    wallShape.lineTo(-width, -WALL_HEIGHT);

    // Add door if needed
    if (hasDoor) {
        const doorHole = new THREE.Path();
        doorHole.moveTo(doorX - DOOR_WIDTH / 2, -WALL_HEIGHT);
        doorHole.lineTo(doorX + DOOR_WIDTH / 2, -WALL_HEIGHT);
        doorHole.lineTo(doorX + DOOR_WIDTH / 2, -WALL_HEIGHT + DOOR_HEIGHT);
        doorHole.lineTo(doorX - DOOR_WIDTH / 2, -WALL_HEIGHT + DOOR_HEIGHT);
        doorHole.lineTo(doorX - DOOR_WIDTH / 2, -WALL_HEIGHT);
        wallShape.holes.push(doorHole);
    }

    // Add windows
    windows.forEach(window => {
        const { x, y } = window;
        const windowHole = new THREE.Path();
        windowHole.moveTo(x - WINDOW_WIDTH / 2, y - WINDOW_HEIGHT / 2);
        windowHole.lineTo(x + WINDOW_WIDTH / 2, y - WINDOW_HEIGHT / 2);
        windowHole.lineTo(x + WINDOW_WIDTH / 2, y + WINDOW_HEIGHT / 2);
        windowHole.lineTo(x - WINDOW_WIDTH / 2, y + WINDOW_HEIGHT / 2);
        windowHole.lineTo(x - WINDOW_WIDTH / 2, y - WINDOW_HEIGHT / 2);
        wallShape.holes.push(windowHole);
    });

    const extrudeSettings = { depth: WALL_THICKNESS, bevelEnabled: false };

    // Validate wallShape before creating geometry
    const isValidShape = wallShape.getPoints().every(point => !isNaN(point.x) && !isNaN(point.y));

    if (!isValidShape) {
        console.error("Invalid wall shape detected. Skipping geometry creation.");
        return null;
    }

    // Create window glass and frames
    const windowElements = windows.map((window, index) => {
        const { x, y } = window;
        const glassDepth = WALL_THICKNESS;

        return (
            <group key={index} position={[x, y, 0]}>
                <mesh position={[0, 0, 0.1]}> {/* Slightly in front of frame */}
                    <boxGeometry args={[WINDOW_WIDTH, WINDOW_HEIGHT, glassDepth]} />
                    <meshPhysicalMaterial
                        color='black'
                        transparent={true}
                        opacity={0.3}
                        metalness={0.3}
                        roughness={0.01}
                        transmission={0.9} // Glass-like transparency
                    />
                </mesh>
            </group>
        );
    });

    return (
        <group position={position}>
            {/* Wall with window holes */}
            <mesh rotation={rotation}>
                <extrudeGeometry args={[wallShape, extrudeSettings]} />
                <meshStandardMaterial color={color} />
            </mesh>

            {/* Window glass elements - positioned relative to the wall */}
            <group rotation={rotation}>
                {windowElements}
            </group>
        </group>
    );
};

// Utility function to generate pairs of windows for an array of x positions
const generateWindowPane = (xValues) => {
    const windowY = 0.2; // Fixed vertical position for windows
    return xValues.flatMap((x) => [
        { x: x - (WINDOW_WIDTH / 2 + WINDOW_PANE_GAP / 2), y: windowY },
        { x: x + (WINDOW_WIDTH / 2 + WINDOW_PANE_GAP / 2), y: windowY },
    ]);
};

// Compute evenly distributed x positions for windows based on room dimension
const computeWindowPositions = (dimension, offset = 0) => {
    const numWindows = parseInt((dimension - offset) / 1); // At least 2 windows, increase with dimension
    const start = -(dimension + offset) / 2;
    const step = dimension / (numWindows - 1);
    return Array.from({ length: numWindows }, (_, i) => start + i * step);
};

// 🏠 Custom Roof with Rectangular Base
const Roof = ({ width, length, height, rotation, y = WALL_HEIGHT }) => {
    const BASE_OFFSET = 0.5; // Controls how much the peak is inset

    const geometry = useMemo(() => {
        // Ensure dimensions are valid and non-zero
        if (isNaN(width) || isNaN(length) || isNaN(height) || width <= 0 || length <= 0 || height <= 0) {
            console.error("Invalid dimensions detected in roof geometry. Replacing with default values.");
            return new THREE.BufferGeometry(); // Return an empty geometry to prevent errors
        }

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

        // Validate vertices to ensure no NaN values
        if (vertices.some((v) => isNaN(v))) {
            console.error("Invalid vertices detected in roof geometry. Replacing with default values.");
            return new THREE.BufferGeometry(); // Return an empty geometry to prevent errors
        }

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
        <mesh rotation={rotation} position={[0, y, 0]} geometry={geometry}>
            <meshStandardMaterial side={THREE.DoubleSide} color="brown" />
        </mesh>
    );
};

const Room = ({ roomWidth, roomLength, quadrantX = 1, quadrantY = 1, doorSide = false, doorFront = false, wallSide = true, numWindows = 1, doorX = 0, skipWalls = [] }) => {
    const shouldRenderWall = (wallQuadrantX, wallQuadrantY) => {
        return !skipWalls.some(
            (skipWall) => skipWall.quadrantX === wallQuadrantX && skipWall.quadrantY === wallQuadrantY
        );
    };

    return (
        <group>
            {wallSide && shouldRenderWall(quadrantX, quadrantY + 1) && (
                <Wall
                    hasDoor={doorSide}
                    position={[quadrantX > 0 ? 0 : -WALL_THICKNESS, 0, quadrantY * roomLength / 2]}
                    rotation={[0, Math.PI / 2, 0]}
                    width={roomLength / 2}
                    doorX={doorX}
                />
            )}
            {shouldRenderWall(quadrantX + 1, quadrantY) && (
                <Wall
                    hasDoor={doorFront}
                    position={[quadrantX * roomWidth / 2, 0, 0]}
                    rotation={[0, 0, 0]}
                    width={roomWidth / 2}
                    doorX={doorX}
                />
            )}
        </group>
    );
}

const Rooms = ({ roomWidth, roomLength, numWindows, type }) => {
    const numRooms = type === "solo" ? 1 : Math.floor(Math.random() * 3) + 2; // Solo has 1 room, others have 2-4
    const rooms = Array.from({ length: numRooms }, (_, i) => {
        const quadrantX = Math.random() > 0.5 ? 1 : -1;
        const quadrantY = Math.random() > 0.5 ? 1 : -1;
        const doorX = 0;

        return {
            quadrantX,
            quadrantY,
            doorSide: type === "connected" && i === 0, // First room has a side door for connected rooms
            doorFront: type !== "solo" || i === 0, // Ensure at least one door for solo/unconnected rooms
            doorX,
        };
    });

    const isAdjoining = (roomA, roomB) => {
        return (
            roomA.quadrantX === roomB.quadrantX &&
            Math.abs(roomA.quadrantY - roomB.quadrantY) === 2
        ) || (
                roomA.quadrantY === roomB.quadrantY &&
                Math.abs(roomA.quadrantX - roomB.quadrantX) === 2
            );
    };

    return (
        <group>
            {rooms.map((room, index) => {
                const adjoiningRooms = rooms.filter((otherRoom, otherIndex) =>
                    otherIndex !== index && isAdjoining(room, otherRoom)
                );

                return (
                    <Room
                        key={index}
                        doorSide={room.doorSide}
                        doorFront={room.doorFront}
                        roomWidth={roomWidth}
                        roomLength={roomLength}
                        quadrantX={room.quadrantX}
                        quadrantY={room.quadrantY}
                        numWindows={numWindows}
                        doorX={room.doorX}
                        skipWalls={adjoiningRooms.map(adjRoom => ({
                            quadrantX: adjRoom.quadrantX,
                            quadrantY: adjRoom.quadrantY,
                        }))}
                    />
                );
            })}
        </group>
    );
};

const Storey = ({ index, roomWidth, roomLength, doorX = 0, numWindows, renderRooms }) => {
    const frontBackWindowPositions = computeWindowPositions(roomWidth);
    const sideWindowPositions = computeWindowPositions(roomLength);
    const mainWindowPositions = computeWindowPositions(roomWidth, 1.4);
    return (
        <group position={[0, index * WALL_HEIGHT * 2, 0]}>
            {/* Front wall with door and windows */}
            <Wall
                hasDoor={index === 0}
                position={[0, 0, -roomLength]}
                doorX={doorX}
                width={roomWidth}
                windows={index === 0 ? generateWindowPane(mainWindowPositions) : generateWindowPane(frontBackWindowPositions)}
            />

            {/* Back wall with windows */}
            <Wall
                position={[0, 0, roomLength - WALL_THICKNESS]}
                width={roomWidth}
                windows={generateWindowPane(frontBackWindowPositions)}
            />

            {/* Right wall with windows */}
            <Wall
                position={[roomWidth - WALL_THICKNESS, 0, 0]}
                rotation={[0, Math.PI / 2, 0]}
                width={roomLength}
                windows={generateWindowPane(sideWindowPositions)}
            />

            {/* Left wall with windows */}
            <Wall
                position={[-roomWidth, 0, 0]}
                rotation={[0, Math.PI / 2, 0]}
                width={roomLength}
                windows={generateWindowPane(sideWindowPositions)}
            />

            {/* Render rooms */}
            {renderRooms()}

            {/* Floor */}
            <mesh position={[0, -1, 0]}>
                <boxGeometry args={[roomWidth * 2.001, 0.2, roomLength * 2.001]} />
                <meshStandardMaterial color="gray" />
            </mesh>
        </group>
    );
};

const House = ({ roofHeight, renderGrass, doorX, houseWidth, houseLength, numStories, numWindows = 2, roomsPerStorey }) => {
    const renderRooms = (type) => {
        return <Rooms roomLength={houseLength} roomWidth={houseWidth} numWindows={numWindows} type={type} />;
    };

    return (
        <group rotation={[0, Math.PI * 5 / 4, 0]}>
            {renderGrass && (
                <mesh position={[0, -0.01 - WALL_HEIGHT, 0]} rotation={[-Math.PI / 2, 0, 0]}>
                    <planeGeometry args={[1000, 1000]} />
                    <meshStandardMaterial color="green" />
                </mesh>
            )}
            {
                [...Array(numStories)].map((_, i) => (
                    <Storey
                        key={i}
                        index={i}
                        roomWidth={houseWidth}
                        roomLength={houseLength}
                        doorX={doorX} // Pass doorX dynamically
                        numWindows={numWindows}
                        renderRooms={() => renderRooms("unconnected")} // Example: Use "unconnected" as default
                    />
                ))
            }
            <Roof
                width={houseWidth * 2}
                length={houseLength * 2}
                height={roofHeight}
                y={1 + (numStories - 1) * 2}
            />
            <ambientLight intensity={0.5} />
            <directionalLight position={[5, 5, 5]} intensity={1} />
        </group>
    );
};

const HouseScene = () => {
    const [roofHeight, setRoofHeight] = useState(1);
    const [renderGrass, setRenderGrass] = useState(true);
    const [houseWidth, setHouseWidth] = useState(4); // Default width
    const [houseLength, setHouseLength] = useState(4); // Default length
    const [numStories, setNumStories] = useState(1); // Default stories
    const [roomsPerStorey, setRoomsPerStorey] = useState([2]); // Default rooms per storey
    const [userPrompt, setUserPrompt] = useState(""); // User prompt state
    const [useWASDControls, setUseWASDControls] = useState(false);
    const doorX = houseWidth - 1;

    const handleNumStoriesChange = (value) => {
        const newNumStories = parseInt(value);
        setNumStories(newNumStories);

        // Adjust the roomsPerStorey array to match the number of stories
        setRoomsPerStorey((prev) => {
            const updated = [...prev];
            while (updated.length < newNumStories) updated.push(2); // Default to 2 rooms per new storey
            while (updated.length > newNumStories) updated.pop();
            return updated;
        });
    };

    const handleRoomsPerStoreyChange = (index, value) => {
        setRoomsPerStorey((prev) => {
            const updated = [...prev];
            updated[index] = Math.min(3, parseInt(value)); // Limit to a maximum of 3 rooms
            return updated;
        });
    };

    const handlePromptSubmit = async () => {
        const ai_key = import.meta.env.VITE_AI_API_KEY;
        try {
            const response = await axios.post("https://api.openai.com/v1/chat/completions", {
                model: "gpt-3.5-turbo", // Use the correct model for chat completions
                messages: [
                    {
                        role: "system",
                        content: "You are a helpful assistant that extracts house parameters from user prompts.",
                    },
                    {
                        role: "user",
                        content: `Parse the following prompt to extract house parameters: ${userPrompt}. Return a JSON object with keys: numStories, houseWidth, houseLength, roomsPerStorey.`,
                    },
                ],
                max_tokens: 200,
            }, {
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${ai_key}`, // Replace with your OpenAI API key
                },
            });

            const parsedData = JSON.parse(response.data.choices[0].message.content.trim());

            // Update state with parsed data or fallback to defaults
            setNumStories(parsedData.numStories || 1);
            setHouseWidth(parsedData.houseWidth || 4);
            setHouseLength(parsedData.houseLength || 4);
            setRoomsPerStorey(Array(parsedData.numStories || 1).fill(2));
        } catch (error) {
            console.error("Error parsing prompt:", error);
            alert("Failed to parse the prompt. Please try again.");
        }
    };

    return (
        <div className="h-screen w-full relative">
            <Canvas camera={{ position: [6, 4, 6], fov: 60 }} fog={{ color: "green", near: 10, far: 50 }}>
                {useWASDControls ? <WASDControls /> : <OrbitControls />}
                <Sky sunPosition={[100, 20, 100]} />
                <House
                    roofHeight={roofHeight}
                    renderGrass={renderGrass}
                    doorX={doorX}
                    houseWidth={houseWidth}
                    houseLength={houseLength}
                    numStories={numStories}
                    roomsPerStorey={roomsPerStorey}
                />
            </Canvas>

            <div className="absolute bottom-5 right-32 transform bg-white p-3 rounded shadow-lg">
                <div className="mb-4 p-2 bg-gray-100 rounded">
                    <label className="block text-sm font-bold mb-2">Camera Controls</label>
                    <div className="flex items-center">
                        <button
                            onClick={() => setUseWASDControls(false)}
                            className={`px-3 py-1 mr-2 rounded ${!useWASDControls ? 'bg-blue-500 text-white' : 'bg-gray-200'}`}
                        >
                            Orbit
                        </button>
                        <button
                            onClick={() => setUseWASDControls(true)}
                            className={`px-3 py-1 rounded ${useWASDControls ? 'bg-blue-500 text-white' : 'bg-gray-200'}`}
                        >
                            WASD
                        </button>
                    </div>
                </div>

                <div className="flex gap-4">
                    <div>
                        <label className="block text-sm font-bold">Roof Height: {roofHeight.toFixed(1)}</label>
                        <input type="range" min="1" max="4" step="0.1" value={roofHeight} onChange={(e) => setRoofHeight(parseFloat(e.target.value))} className="w-40" />
                        <div className="mt-3">
                            <label className="block text-sm font-bold">House Width: {houseWidth.toFixed(1)}</label>
                            <input type="range" min="3" max="7" step="0.1" value={houseWidth} onChange={(e) => setHouseWidth(parseFloat(e.target.value))} className="w-40" />
                        </div>
                        <div className="mt-3">
                            <label className="block text-sm font-bold">House Length: {houseLength.toFixed(1)}</label>
                            <input type="range" min="3" max="7" step="0.1" value={houseLength} onChange={(e) => setHouseLength(parseFloat(e.target.value))} className="w-40" />
                        </div>
                        <div className="mt-3">
                            <label className="block text-sm font-bold"># Stories: {numStories}</label>
                            <input type="range" min="1" max="5" step="1" value={numStories} onChange={(e) => handleNumStoriesChange(e.target.value)} className="w-40" />
                        </div>
                        {roomsPerStorey.map((rooms, index) => (
                            <div className="mt-3" key={index}>
                                <label className="block text-sm font-bold"># Rooms in Storey {index + 1}: {rooms}</label>
                                <input
                                    type="range"
                                    min="1"
                                    max="3" // Limit to a maximum of 3 rooms
                                    step="1"
                                    value={rooms}
                                    onChange={(e) => handleRoomsPerStoreyChange(index, e.target.value)}
                                    className="w-40"
                                />
                            </div>
                        ))}
                        <div className="mt-3">
                            <label className="block text-sm font-bold">Render Grass</label>
                            <input type="checkbox" checked={renderGrass} onChange={() => setRenderGrass(!renderGrass)} className="ml-2" />
                        </div>
                    </div>
                    <div className="mt-3">
                        <label className="block text-sm font-bold">User Prompt</label>
                        <textarea
                            value={userPrompt}
                            onChange={(e) => setUserPrompt(e.target.value)}
                            className="w-full p-2 border rounded"
                            rows="4"
                            placeholder="Describe your house (e.g., 3 stories, 5x5 house)..."
                        />
                        <button
                            onClick={handlePromptSubmit}
                            className="mt-2 px-3 py-1 bg-blue-500 text-white rounded"
                        >
                            Submit Prompt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default HouseScene;
